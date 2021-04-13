<?php

namespace Core\Router;

use JetBrains\PhpStorm\Pure;

class Route {

    private string $method;
    private string $url;
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
    #[Pure] public function __construct(string $method, string $url, string $name, mixed $callback)
    {
        $this->method = $method;
        $this->url = $url;
        $this->name = $name;
        $this->param = "";
        $this->callback = $callback;
    }

    // Route Logic
    public function render() {
        // todo make render
    }

    // Getter

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
    public function setUrl(string $url): Route
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getParam(): string
    {
        return $this->param;
    }

    /**
     * @param string $param
     */
    public function setParam(string $param): void
    {
        $this->param = $param;
    }

    /**
     * @return mixed
     */
    public function getCallback(): mixed {
        return $this->callback;
    }
}