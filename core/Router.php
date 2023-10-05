<?php

namespace tframe\core;

use tframe\core\exception\NotFoundException;

class Router {
    private Request $request;
    private Response $response;
    private array $routeMap = [];

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $url, $callback): void {
        $this->routeMap['get'][$url] = $callback;
    }

    public function post(string $url, $callback): void {
        $this->routeMap['post'][$url] = $callback;
    }

    /**
     * @throws \tframe\core\exception\NotFoundException
     */
    public function resolve(): mixed {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();
        $callback = $this->routeMap[$method][$url] ?? false;
        if (!$callback) {
            $callback = $this->getCallback();

            if ($callback === false) {
                throw new NotFoundException();
            }
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            /**
             * @var $controller Controller
             */
            $controller = new $callback[0];
            $controller->action = $callback[1];
            Application::$app->controller = $controller;
            // TODO: permission check
            $callback[0] = $controller;
        }
        return call_user_func($callback, $this->request, $this->response);
    }

    public function getCallback(): mixed {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();
        // Trim slashes
        $url = trim($url, '/');

        // Get all routes for current request method
        $routes = $this->getRouteMap($method);

        $routeParams = false;

        // Start iterating registered routes
        foreach ($routes as $route => $callback) {
            // Trim slashes
            $route = trim($route, '/');
            $routeNames = [];

            if (!$route) {
                continue;
            }

            // Find all route names from route and save in $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }

            // Convert route name into regex pattern
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $route) . "$@";

            // Test and match current route against $routeRegex
            if (preg_match_all($routeRegex, $url, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);

                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }

        return false;
    }

    public function getRouteMap($method): array {
        return $this->routeMap[$method] ?? [];
    }

    public function renderView($view, $params = []): string {
        return Application::$app->view->renderView($view, $params);
    }

    public function renderViewOnly($view, $params = []): string {
        return Application::$app->view->renderViewOnly($view, $params);
    }
}