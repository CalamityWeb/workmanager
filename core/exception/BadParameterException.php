<?php

namespace tframe\core\exception;

use Exception;
use tframe\core\Application;
use Throwable;

class BadParameterException extends Exception {
    public function __construct(?Throwable $previous = null, string $message = "Server error - bad parameter", int $code = 500) {
        Application::$app->view->title = 'ERROR - ' .$code;
        parent::__construct($message, $code, $previous);
    }
}