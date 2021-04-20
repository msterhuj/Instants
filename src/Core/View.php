<?php

namespace Core;

abstract class View {

    private string $ROOT_DIR = "../src/App/Views";

    public function getTemplate(string $templateName): string {
        ob_start();
        include_once $this->ROOT_DIR . "/templates/$templateName.php";
        return ob_get_clean();
    }

    public function render(string $page, array $data) {
        $template = $this->getTemplate("base");

        ob_start();
        include_once $this->ROOT_DIR . "/$page.php";
        $content = str_replace("{{SYSTEM_CONTENT}}", ob_get_clean(), $template);

        foreach ($data as $key => $value) {
            $content = str_replace("{{ " . $key . " }}", $value, $content);
        }

        echo $content;
    }

}