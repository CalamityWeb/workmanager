<?php

namespace tframe\core;

class Request {
    private array $routeParams = [];

    public function getMethod(): string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getUrl(): mixed {
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path, '?');
        if ($position !== false) {
            $path = substr($path, 0, $position);
        }
        return $path;
    }

    public function isGet(): bool {
        return $this->getMethod() === 'get';
    }

    public function isPost(): bool {
        return $this->getMethod() === 'post';
    }

    public function getBody(): array {
        $data = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = $value;
            }
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    public function setRouteParams($params): static {
        $this->routeParams = $params;
        return $this;
    }

    public function getRouteParams(): array {
        return $this->routeParams;
    }

    public function getRouteParam($param, $default = null): mixed {
        return $this->routeParams[$param] ?? $default;
    }
}