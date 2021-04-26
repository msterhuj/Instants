<?php

namespace Core;

use App\Config;

class Mailer {
    const CRLF = "\r\n";

    private mixed $socket;
    private string $subject;
    private string $to;
    private array $from;
    private $content = null;
    private array $logs = array();
    private array $headers = array();

    public function __construct(string $address, string $subject) {
        $this->setHeader('X-Mailer', 'PHP/' . phpversion());
        $this->setHeader('MIME-Version', '1.0');
        $this->to = $address;
        $this->from = [ Config::MAIL_USER, 'No Reply' ];
        $this->subject = $subject;
    }

    private function setHeader($key, $value = null): Mailer {
        $this->headers[$key] = $value;
        return $this;
    }

    public function send(): bool {
        $message = null;
        $this->socket = fsockopen(
            'tcp://' . Config::MAIL_SRV,
            Config::MAIL_PORT,
            $errorNumber,
            $errorMessage,
            Config::MAIL_TIMEOUT
        );

        if (empty($this->socket)) return false;
        $this->logs['CONNECTION'] = $this->getResponse();
        $this->logs['HELLO'][1] = $this->sendCommand('EHLO ' . Config::MAIL_HOSTNAME);
        $this->logs['STARTTLS'] = $this->sendCommand('STARTTLS');
        stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
        $this->logs['HELLO'][2] = $this->sendCommand('EHLO ' . Config::MAIL_HOSTNAME);
        $this->logs['AUTH'] = $this->sendCommand('AUTH LOGIN');
        $this->logs['USERNAME'] = $this->sendCommand(base64_encode(Config::MAIL_USER));
        $this->logs['PASSWORD'] = $this->sendCommand(base64_encode(Config::MAIL_PASS));
        $this->logs['MAIL_FROM'] = $this->sendCommand('MAIL FROM: <' . $this->from[0] . '>');
        $this->logs['RECIPIENTS'][] = $this->sendCommand('RCPT TO: <' . $this->to . '>');

        $this->setHeader('Date', date('r'));
        $this->setHeader('Subject', $this->subject);
        $this->setHeader('From', $this->formatAddress($this->from));
        $this->setHeader('Return-Path', $this->formatAddress($this->from));
        $this->setHeader('To', $this->formatAddress([$this->to, null]));

        $boundary = md5(uniqid(microtime(true), true));
        $this->setHeader('Content-Type', 'multipart/mixed; boundary="mixed-' . $boundary . '"');

        $this->headers['Content-Type'] = 'multipart/alternative; boundary="alt-' . $boundary . '"';

        $message .= '--alt-' . $boundary . self::CRLF;
        $message .= 'Content-Type: text/html; charset=utf-8' . self::CRLF;
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
        stream_set_timeout($this->socket, Config::MAIL_TIMEOUT);
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