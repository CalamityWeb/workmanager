<?php

namespace tframe\core\exception;

use Exception;
use tframe\core\Application;
use Throwable;

class InternalServerErrorException extends Exception {
    public function __construct(string $message = "Internal server error", int $code = 500, ?Throwable $previous = null) {
        Application::$app->view->title = 'ERROR - ' .$code;
        http_response_code($code);
        parent::__construct($message, $code, $previous);
    }
}