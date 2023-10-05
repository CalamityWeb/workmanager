<?php

namespace tframe\core\exception;

use Exception;
use tframe\core\Application;
use Throwable;

class BadRequestException extends Exception {
    public function __construct(string $message = "Bad Request", int $code = 400, ?Throwable $previous = null) {
        Application::$app->view->title = 'ERROR - ' .$code;
        parent::__construct($message, $code, $previous);
    }
}