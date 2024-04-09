<?php

namespace calamity\core\exception;

use Exception;
use calamity\core\Calamity;
use Throwable;

class InvalidConfigException extends Exception {
    public function __construct (string $message = "Invalid configuration provided", int $code = 422, ?Throwable $previous = null) {
        Calamity::$app->view->title = 'ERROR - ' . $code;
        http_response_code($code);
        parent::__construct($message, $code, $previous);
    }
}