<?php

namespace calamity\admin\controllers;

use calamity\common\models\Users;
use calamity\Calamity;
use calamity\auth\ForgotPasswordForm;
use calamity\auth\LoginForm;
use calamity\auth\RegisterForm;
use calamity\auth\ResetPasswordForm;
use calamity\auth\ResetToken;
use calamity\Controller;
use calamity\exception\NotFoundException;
use calamity\Request;
use calamity\Response;

class AuthController extends Controller {
    public function register (Request $request): string {
        $this->setLayout('auth');

        $registerForm = new RegisterForm();
        if ($request->isPost()) {
            $registerForm->loadData($request->getBody());
            if ($registerForm->validate() and $user = $registerForm->register()) {
                Calamity::$app->login($user);
                Calamity::$app->session->setFlash('success', Calamity::t('auth', 'Register successful'), '/site/dashboard');
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
                Calamity::$app->login($user);
                $response->redirect('/site/dashboard');
            }
        }

        if (isset($_COOKIE['rememberMe'])) {
            /** @var Users $user */
            $user = Users::findOne(['id' => $_COOKIE['rememberMe']]);

            if ($user) {
                Calamity::$app->login($user);
                $response->redirect('/site/dashboard');
            }
        }

        $loginForm = new LoginForm();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() and $loginForm->login()) {
                Calamity::$app->session->setFlash('success', Calamity::t('auth', 'Login successful'), '/site/dashboard');
            }
        }

        return $this->render('auth.login', ['loginForm' => $loginForm]);
    }

    public function logout (Request $request, Response $response): void {
        Calamity::$app->logout();
    }

    public function forgotPassword (Request $request): string {
        $this->setLayout('auth');

        $forgotPasswordForm = new ForgotPasswordForm();

        if ($request->isPost()) {
            $forgotPasswordForm->loadData($request->getBody());
            if ($forgotPasswordForm->validate() and $forgotPasswordForm->sendUpdateEmail()) {
                Calamity::$app->session->setFlash('success', Calamity::t('auth', 'Recovery email sent successfully'));
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

                Calamity::$app->session->setFlash('success', Calamity::t('auth', 'Password updated successfully'), '/auth/login');
            }
        }

        return $this->render('auth.reset-password', ['resetPasswordForm' => $resetPasswordForm]);
    }
}