<?php

namespace tframe\admin\controllers;

use tframe\core\Application;
use tframe\core\auth\LoginForm;
use tframe\core\auth\RegisterForm;
use tframe\core\Controller;
use tframe\core\Request;

class AuthController extends Controller {
    public function login(Request $request): string {
        $this->layout = 'auth';

        $loginForm = new LoginForm();
        if($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if($loginForm->validate() and $loginForm->login()) {
                Application::$app->session->setFlash('success', 'Login successful');
            }
        }

        return $this->render('auth.login', ['loginForm' => $loginForm]);
    }

    public function register(Request $request): string {
        $this->layout = 'auth';

        $registerForm = new RegisterForm();
        if($request->isPost()) {
            $registerForm->loadData($request->getBody());
            if($registerForm->validate() and $registerForm->register()) {
                Application::$app->session->setFlash('success', 'Login successful');
            }
        }

        return $this->render('auth.register');
    }
}