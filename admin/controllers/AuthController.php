<?php

namespace tframe\admin\controllers;

use tframe\common\models\User;
use tframe\core\Application;
use tframe\core\auth\LoginForm;
use tframe\core\auth\RegisterForm;
use tframe\core\Controller;
use tframe\core\Request;
use tframe\core\Response;

class AuthController extends Controller {
    public function login(Request $request, Response $response): string {
        $this->setLayout('auth');

        if (isset($_COOKIE['rememberMe'])) {
            /** @var User $user */
            $user = User::findOne(['id' => $_COOKIE['rememberMe']]);

            if ($user) {
                Application::$app->login($user);
                $response->redirect('/site/dashboard');
            }
        }

        $loginForm = new LoginForm();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() and $loginForm->login()) {
                Application::$app->session->setFlash('success', Application::t('auth', 'Login successful'));
            }
        }

        return $this->render('auth.login', ['loginForm' => $loginForm]);
    }

    public function register(Request $request): string {
        $this->setLayout('auth');

        $registerForm = new RegisterForm();
        if ($request->isPost()) {
            $registerForm->loadData($request->getBody());
            if ($registerForm->validate() and $registerForm->register()) {
                Application::$app->session->setFlash('success', Application::t('auth', 'Register successful'));
            }
        }

        return $this->render('auth.register', ['registerForm' => $registerForm]);
    }
}