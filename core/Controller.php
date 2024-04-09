<?php

namespace calamity\core;

class Controller {
    public string $layout = 'main';
    public string $action = '';

    public function setLayout ($layout): void {
        $this->layout = $layout;
    }

    public function render ($view, $params = []): string {
        return Calamity::$app->router->renderView($view, $params);
    }

    public function renderViewOnly ($view, $params = []): string {
        return Calamity::$app->router->renderViewOnly($view, $params);
    }
}