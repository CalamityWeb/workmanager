<?php

namespace tframe\core\exception;

use Exception;
use tframe\core\Application;
use Throwable;

class UnauthorizedException extends Exception {
    public function __construct(?Throwable $previous = null, string $message = "You are not authorized to view this page", int $code = 401) {
        Application::$app->view->title = 'ERROR - ' .$code;
        parent::__construct($message, $code, $previous);
    }
}