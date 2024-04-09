<?php

namespace calamity\core;

use calamity\common\helpers\CoreHelper;

class View {
    public string $title = '';
    public string $css = '<style> </style>';
    public string $js = '<script> </script>';

    public function registerJS (string $js): void {
        $this->js = substr_replace($this->js, $js, -10, 0) . ' ';
    }

    public function registerCSS (string $css): void {
        $this->css = substr_replace($this->css, $css, -9, 1) . ' ';
    }

    public function renderView ($view, array $params): string {
        $layoutName = Calamity::$app->controller->layout ?? Calamity::$app->layout;
        if (str_contains($layoutName, '.')) {
            $layoutName = str_replace('.', '/', $layoutName);
        }
        $viewContent = $this->renderViewOnly($view, $params);
        ob_start();
        include_once $this->layoutPathBuilder($layoutName);
        $layoutContent = ob_get_clean();
        return str_replace(['{{content}}', '{{css}}', '{{js}}'], [$viewContent, $this->css, $this->js], $layoutContent);
    }

    public function renderViewOnly ($view, array $params): string {
        if (str_contains($view, '.')) {
            $view = str_replace('.', '/', $view);
        }
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once $this->viewPathBuilder($view);
        return ob_get_clean();
    }

    private function viewPathBuilder ($view): string {
        if (CoreHelper::checkAlias($view)) {
            $view = CoreHelper::getAlias($view);
            $view = substr_replace($view, 'views/', strrpos($view, '/'), 1) . '.php';
        } else {
            $view = Calamity::$ROOT_DIR . "/views/$view.php";
        }
        return $view;
    }

    private function layoutPathBuilder ($layout): string {
        if (CoreHelper::checkAlias($layout)) {
            $layout = CoreHelper::getAlias($layout);
            $layout = substr_replace($layout, 'views/layouts/', strpos($layout, '/'), 1) . '.php';
        } else {
            $layout = Calamity::$ROOT_DIR . "/views/layouts/$layout.php";
        }
        return $layout;
    }
}