<?php

namespace tframe\core\exception;

use Exception;
use tframe\core\Application;
use Throwable;

class InvalidArgumentException extends Exception {
    public function __construct(string $message = "Invalid argument provided", int $code = 400, ?Throwable $previous = null) {
        Application::$app->view->title = 'ERROR - ' .$code;
        parent::__construct($message, $code, $previous);
    }
}