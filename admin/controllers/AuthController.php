<?php

namespace tframe\admin\controllers;

use tframe\core\Controller;

class AuthController extends Controller {
    public function login(): string {
        $this->layout = 'auth';
        return $this->render('auth.login');
    }
}