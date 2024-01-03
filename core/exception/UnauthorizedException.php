<?php

namespace tframe\core\exception;

use Exception;
use tframe\core\Application;
use Throwable;

class UnauthorizedException extends Exception {
    public function __construct(string $message = "You are not authorized to view this page", int $code = 401, ?Throwable $previous = null) {
        Application::$app->view->title = 'ERROR - ' .$code;
        http_response_code($code);
        parent::__construct($message, $code, $previous);
    }
}