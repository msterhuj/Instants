<?php

namespace Core;

class Mailer {

    private string $ROOT_DIR = "../src/App/Views/mail";

    private string $content;

    public function send(): Mailer {
        $socket = fsockopen(
            "tcp://mail.instants.dev",
            25,
            $errorNumber,
            $errorMessage,
            10
        );
        //
        return $this;
    }

    public function render(string $page, array $data = []): Mailer {
        ob_start();
        include_once $this->ROOT_DIR . "/$page.php";
        $this->content = ob_get_clean();
        foreach ($data as $key => $value) {
            $this->content = str_replace("{{ " . $key . " }}", $value, $this->content);
        }
        return $this;
    }
}