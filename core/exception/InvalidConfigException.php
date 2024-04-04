<?php

namespace tframe\core\exception;

use Exception;
use tframe\core\Application;
use Throwable;

class InvalidConfigException extends Exception {
    public function __construct (string $message = "Invalid configuration provided", int $code = 422, ?Throwable $previous = null) {
        Application::$app->view->title = 'ERROR - ' . $code;
        http_response_code($code);
        parent::__construct($message, $code, $previous);
    }
}