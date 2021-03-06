<?php

namespace Core\Router;

class Route {

    private string $method;
    private string $url;
    private string $url_reg;
    private string $name;
    private string $param;
    private mixed $callback;

    /**
     * Route constructor.
     * @param string $method
     * @param string $url
     * @param string $name
     * @param mixed $callback
     */
    public function __construct(string $method, string $url, string $name, mixed $callback) {
        $this->method = $method;
        $this->url = $url;
        $this->name = $name;
        $this->param = "";
        $this->callback = $callback;
    }

    /**
     * @return string
     */
    public static function getRouteParam(): string {
        return $_SESSION['ROUTE']->getParam();
    }

    /**
     * @return string
     */
    public function getMethod(): string {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUrl(): string {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Route
     */
    public function setUrl(string $url): Route {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlReg(): string
    {
        return $this->url_reg;
    }

    /**
     * @param string $url_reg
     */
    public function setUrlReg(string $url_reg): void
    {
        $this->url_reg = $url_reg;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getParam(): string {
        return $this->param;
    }

    /**
     * @param string $param
     * @return Route
     */
    public function setParam(string $param): Route {
        $this->param = $param;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallback(): mixed {
        return $this->callback;
    }
}