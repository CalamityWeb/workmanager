<?php

namespace tframe\core;

use tframe\common\models\Users;
use tframe\core\exception\ForbiddenException;
use tframe\core\exception\NotFoundException;
use tframe\core\exception\ServiceUnavailableException;

class Router {
    private Request $request;
    private Response $response;
    private array $routeMap = [];

    public function __construct (Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function get (string $url, $callback): void {
        $this->routeMap['get'][$url] = $callback;
    }

    public function post (string $url, $callback): void {
        $this->routeMap['post'][$url] = $callback;
    }

    public function getNpost (string $url, $callback): void {
        $this->routeMap['get'][$url] = $callback;
        $this->routeMap['post'][$url] = $callback;
    }

    /**
     * @throws \tframe\core\exception\NotFoundException
     * @throws \tframe\core\exception\ServiceUnavailableException
     * @throws \tframe\core\exception\ForbiddenException
     * @throws \tframe\core\exception\UnauthorizedException
     */
    public function resolve (): mixed {
        if (Application::$app->maintenance) {
            throw new ServiceUnavailableException(Application::t('general', 'Maintenance in progress'));
        }

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
            $controller = new $callback[0]();
            $controller->action = $callback[1];
            Application::$app->controller = $controller;

            if (isset($_COOKIE['rememberMe'])) {
                /** @var Users $user */
                $user = Users::findOne(['id' => $_COOKIE['rememberMe']]);

                if ($user) {
                    Application::$app->login($user);
                }
            }

            $modified = $this->getHost($url);
            if (!Users::canRoute(Application::$app->user, $modified)) {
                throw new ForbiddenException();
            }

            $callback[0] = $controller;
        }
        return $callback($this->request, $this->response);
    }

    public function getCallback (): mixed {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();
        // Trim slashes
        $url = trim($url, '/');

        // Get all routes for current request method
        $routes = $this->getRouteMap($method);

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
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', static fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $route) . "$@";

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

    public function getRouteMap ($method): array {
        return $this->routeMap[$method] ?? [];
    }

    public function renderView ($view, $params = []): string {
        return Application::$app->view->renderView($view, $params);
    }

    private function getHost (mixed $url): string {
        $host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
        if ($host == Application::$URL['@admin']) {
            $modified = '@admin' . $url;
        } elseif ($host == Application::$URL['@public']) {
            $modified = '@public' . $url;
        } else {
            $modified = '';
        }
        return $modified;
    }

    public function renderViewOnly ($view, $params = []): string {
        return Application::$app->view->renderViewOnly($view, $params);
    }
}