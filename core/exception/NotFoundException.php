<?php

namespace calamity\core\exception;

use Exception;
use calamity\core\Calamity;
use Throwable;

class NotFoundException extends Exception {
    public function __construct (string $message = "This page is not found", int $code = 404, ?Throwable $previous = null) {
        Calamity::$app->view->title = 'ERROR - ' . $code;
        http_response_code($code);
        parent::__construct($message, $code, $previous);
    }
}