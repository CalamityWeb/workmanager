<?php

namespace tframe\core\exception;

use Exception;
use tframe\core\Application;
use Throwable;

class ForbiddenException extends Exception {
    public function __construct (string $message = "You don't have permission to view this page", int $code = 403, ?Throwable $previous = null) {
        Application::$app->view->title = 'ERROR - ' . $code;
        http_response_code($code);
        parent::__construct($message, $code, $previous);
    }
}