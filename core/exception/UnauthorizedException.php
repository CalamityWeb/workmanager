<?php

namespace calamity\core\exception;

use Exception;
use calamity\core\Calamity;
use Throwable;

class UnauthorizedException extends Exception {
    public function __construct (string $message = "You are not authorized to view this page", int $code = 401, ?Throwable $previous = null) {
        Calamity::$app->view->title = 'ERROR - ' . $code;
        http_response_code($code);
        parent::__construct($message, $code, $previous);
    }
}