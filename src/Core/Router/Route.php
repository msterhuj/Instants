<?php

namespace Core\Router;

use JetBrains\PhpStorm\Pure;

class Route {

    private string $method;
    private string $url;
    private string $name;
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
        $this->callback = $callback;
    }

    // Route Logic

    public function match(): bool {

    }

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCallback(): mixed {
        return $this->callback;
    }
}