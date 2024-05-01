<?php

namespace calamity\common\models\core;

class Response {
    public function statusCode(int $code): void {
        http_response_code($code);
    }

    public function redirect($url): void {
        header("Location: $url");
    }
}