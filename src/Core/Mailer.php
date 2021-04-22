<?php

namespace Core;

class Mailer {
    const CRLF = "\r\n";

    private string $server = "mail.instants.dev";
    private int $port = 587;
    private string $hostname = "instants.dev";
    private mixed $socket;
    private string $username = "noreply@instants.dev";
    private string $password = "";
    private int $connectionTimeout = 30;
    private int $responseTimeout = 8;
    private string $subject;
    private string $to;
    private array $from;
    private $protocol = 'tcp';
    private $content = null;
    private array $logs = array();
    private string $charset = 'utf-8';
    private array $headers = array();

    public function __construct(string $address, string $subject) {
        $this->setHeader('X-Mailer', 'PHP/' . phpversion());
        $this->setHeader('MIME-Version', '1.0');
        $this->to = $address;
        $this->from = [ $this->username, 'No Reply' ];
        $this->subject = $subject;
    }

    private function setHeader($key, $value = null): Mailer {
        $this->headers[$key] = $value;
        return $this;
    }

    public function send(): bool {
        $message = null;
        $this->socket = fsockopen(
            $this->protocol . '://' . $this->server,
            $this->port,
            $errorNumber,
            $errorMessage,
            $this->connectionTimeout
        );

        if (empty($this->socket)) return false;
        $this->logs['CONNECTION'] = $this->getResponse();
        $this->logs['HELLO'][1] = $this->sendCommand('EHLO ' . $this->hostname);
        $this->logs['STARTTLS'] = $this->sendCommand('STARTTLS');
        stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
        $this->logs['HELLO'][2] = $this->sendCommand('EHLO ' . $this->hostname);
        $this->logs['AUTH'] = $this->sendCommand('AUTH LOGIN');
        $this->logs['USERNAME'] = $this->sendCommand(base64_encode($this->username));
        $this->logs['PASSWORD'] = $this->sendCommand(base64_encode($this->password));
        $this->logs['MAIL_FROM'] = $this->sendCommand('MAIL FROM: <' . $this->from[0] . '>');
        $this->logs['RECIPIENTS'][] = $this->sendCommand('RCPT TO: <' . $this->to . '>');

        $this->setHeader('Date', date('r'));
        $this->setHeader('Subject', $this->subject);
        $this->setHeader('From', $this->formatAddress($this->from));
        $this->setHeader('Return-Path', $this->formatAddress($this->from));
        $this->setHeader('To', $this->formatAddress($this->to));

        $boundary = md5(uniqid(microtime(true), true));
        $this->setHeader('Content-Type', 'multipart/mixed; boundary="mixed-' . $boundary . '"');

        $this->headers['Content-Type'] = 'multipart/alternative; boundary="alt-' . $boundary . '"';

        $message .= '--alt-' . $boundary . self::CRLF;
        $message .= 'Content-Type: text/html; charset=' . $this->charset . self::CRLF;
        $message .= 'Content-Transfer-Encoding: base64' . self::CRLF . self::CRLF;
        $message .= chunk_split(base64_encode($this->content)) . self::CRLF;
        $message .= '--alt-' . $boundary . '--' . self::CRLF . self::CRLF;

        $headers = '';
        foreach ($this->headers as $k => $v) {
            $headers .= $k . ': ' . $v . self::CRLF;
        }

        $this->logs['MESSAGE'] = $message;
        $this->logs['HEADERS'] = $headers;
        $this->logs['DATA'][1] = $this->sendCommand('DATA');
        $this->logs['DATA'][2] = $this->sendCommand($headers . self::CRLF . $message . self::CRLF . '.');
        $this->logs['QUIT'] = $this->sendCommand('QUIT');
        fclose($this->socket);
        return substr($this->logs['DATA'][2], 0, 3) == 250;
    }

    private function getResponse(): string {
        $response = '';
        stream_set_timeout($this->socket, $this->responseTimeout);
        while (($line = fgets($this->socket, 515)) !== false) {
            $response .= trim($line) . "\n";
            if (substr($line, 3, 1) == ' ') {
                break;
            }
        }
        return trim($response);
    }

    private function sendCommand($command): string {
        fputs($this->socket, $command . self::CRLF);
        return $this->getResponse();
    }

    private function formatAddress($address): string {
        return (empty($address[1])) ? $address[0] : '"' . addslashes($address[1]) . '" <' . $address[0] . '>';
    }

    public function render(string $page, array $data = []): Mailer {
        ob_start();
        include_once "../src/App/Views/mail/$page.php";
        $this->content = ob_get_clean();
        foreach ($data as $key => $value) {
            $this->content = str_replace("{{ " . $key . " }}", $value, $this->content);
        }
        return $this;
    }
}