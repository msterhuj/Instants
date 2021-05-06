<?php

namespace Core\Controller;

abstract class View {

    private string $ROOT_DIR = "../src/App/Views";
    private string $template = "base";
    private string $css = "";
    private string $js = "";

    public function setTemplate(string $templateName): View {
        $this->template = $templateName;
        return $this;
    }

    public function getTemplate(string $templateName): string {
        ob_start();
        include_once $this->ROOT_DIR . "/templates/$templateName.php";
        return ob_get_clean();
    }

    public function render(string $page, array $data = []) {
        $template = $this->getTemplate($this->template);

        ob_start();
        include_once $this->ROOT_DIR . "/$page.php";
        $content = str_replace("{{ SYSTEM_CONTENT }}", ob_get_clean(), $template);
        $content = str_replace("{{ CSS }}", $this->css, $content);
        $content = str_replace("{{ JS }}", $this->js, $content);

        foreach ($data as $key => $value) {
            $content = str_replace("{{ " . $key . " }}", $value, $content);
        }

        echo $content;
    }

    public function appendCSS(array $css): View {
        foreach ($css as $c) {
            $this->css .= '<link rel="stylesheet" href="/assets/css/'.$c.'.css">';
        }
        return $this;
    }

    public function appendJS(array $js): View {
        foreach ($js as $j) {
            $this->css .= '<script src="/assets/js/'.$j.'.js"></script>';
        }
        return $this;
    }
}