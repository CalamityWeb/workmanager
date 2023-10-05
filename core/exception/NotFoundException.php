<?php

namespace tframe\core\exception;

use Exception;
use tframe\core\Application;
use Throwable;

class NotFoundException extends Exception {
    public function __construct(string $message = "This page is not found", int $code = 404, ?Throwable $previous = null) {
        Application::$app->view->title = 'ERROR - ' .$code;
        parent::__construct($message, $code, $previous);
    }
}