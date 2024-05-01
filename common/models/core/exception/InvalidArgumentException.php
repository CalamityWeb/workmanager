<?php

namespace calamity\common\models\core\exception;

use calamity\common\models\core\Calamity;
use Exception;
use Throwable;

class InvalidArgumentException extends Exception {
    public function __construct(string $message = "Invalid argument provided", int $code = 400, ?Throwable $previous = null) {
        Calamity::$app->view->title = 'ERROR - ' . $code;
        http_response_code($code);
        parent::__construct($message, $code, $previous);
    }
}