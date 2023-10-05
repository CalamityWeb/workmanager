<?php

namespace tframe\core\exception;

use Exception;
use tframe\core\Application;
use Throwable;

class ServiceUnavailableException extends Exception {
    public function __construct(string $message = "Service Unavailable", int $code = 503, ?Throwable $previous = null) {
        Application::$app->view->title = 'ERROR - ' .$code;
        parent::__construct($message, $code, $previous);
    }
}