<?php

namespace tframe\core\exception;

use Exception;
use tframe\core\Application;
use Throwable;

class ForbiddenException extends Exception {
    public function __construct(?Throwable $previous = null, string $message = "You don't have permission to view this page", int $code = 403) {
        Application::$app->view->title = 'ERROR - ' .$code;
        parent::__construct($message, $code, $previous);
    }
}