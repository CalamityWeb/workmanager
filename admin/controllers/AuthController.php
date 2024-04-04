<?php

namespace tframe\admin\controllers;

use tframe\common\models\Users;
use tframe\core\Application;
use tframe\core\auth\ForgotPasswordForm;
use tframe\core\auth\LoginForm;
use tframe\core\auth\RegisterForm;
use tframe\core\auth\ResetPasswordForm;
use tframe\core\auth\ResetToken;
use tframe\core\Controller;
use tframe\core\exception\NotFoundException;
use tframe\core\Request;
use tframe\core\Response;

class AuthController extends Controller {
    public function register (Request $request): string {
        $this->setLayout('auth');

        $registerForm = new RegisterForm();
        if ($request->isPost()) {
            $registerForm->loadData($request->getBody());
            if ($registerForm->validate() and $user = $registerForm->register()) {
                Application::$app->login($user);
                Application::$app->session->setFlash('success', Application::t('auth', 'Register successful'), '/site/dashboard');
            }
        }

        return $this->render('auth.register', ['registerForm' => $registerForm]);
    }

    public function login (Request $request, Response $response): string {
        $this->setLayout('auth');

        if (isset($_COOKIE['sessionUser'])) {
            /** @var Users $user */
            $user = Users::findOne(['id' => $_COOKIE['sessionUser']]);

            if ($user) {
                Application::$app->login($user);
                $response->redirect('/site/dashboard');
            }
        }

        if (isset($_COOKIE['rememberMe'])) {
            /** @var Users $user */
            $user = Users::findOne(['id' => $_COOKIE['rememberMe']]);

            if ($user) {
                Application::$app->login($user);
                $response->redirect('/site/dashboard');
            }
        }

        $loginForm = new LoginForm();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() and $loginForm->login()) {
                Application::$app->session->setFlash('success', Application::t('auth', 'Login successful'), '/site/dashboard');
            }
        }

        return $this->render('auth.login', ['loginForm' => $loginForm]);
    }

    public function logout (Request $request, Response $response): void {
        Application::$app->logout();
    }

    public function forgotPassword (Request $request): string {
        $this->setLayout('auth');

        $forgotPasswordForm = new ForgotPasswordForm();

        if ($request->isPost()) {
            $forgotPasswordForm->loadData($request->getBody());
            if ($forgotPasswordForm->validate() and $forgotPasswordForm->sendUpdateEmail()) {
                Application::$app->session->setFlash('success', Application::t('auth', 'Recovery email sent successfully'));
            }
        }

        return $this->render('auth.forgot-password', ['forgotPasswordForm' => $forgotPasswordForm]);
    }

    public function resetPassword (Request $request): string {
        $this->setLayout('auth');

        /** @var ResetToken $token */
        $token = ResetToken::findOne(['token' => $request->getRouteParam('token')]);
        if (!$token) {
            throw new NotFoundException();
        }
        if ($token->completed_at != null or date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime('+1 day', strtotime($token->created_at)))) {
            throw new NotFoundException();
        }

        $resetPasswordForm = new ResetPasswordForm();

        if ($request->isPost()) {
            $resetPasswordForm->loadData($request->getBody());
            if ($resetPasswordForm->validate()) {
                /** @var Users $user */
                $user = Users::findOne(['id' => $token->userId]);
                $user->password = password_hash($resetPasswordForm->password, PASSWORD_ARGON2ID, ['memory_cost' => 65536, 'time_cost' => 4, 'threads' => 3]);
                $user->save();

                $token->completed_at = date('Y-m-d H:i:s');
                $token->save();

                Application::$app->session->setFlash('success', Application::t('auth', 'Password updated successfully'), '/auth/login');
            }
        }

        return $this->render('auth.reset-password', ['resetPasswordForm' => $resetPasswordForm]);
    }
}