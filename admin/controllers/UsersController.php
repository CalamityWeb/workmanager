<?php

namespace tframe\admin\controllers;

use tframe\common\models\User;
use tframe\core\Application;
use tframe\core\auth\RegisterForm;
use tframe\core\Controller;
use tframe\core\Request;

class UsersController extends Controller {
    public function listUsers(): string {
        $this->setLayout('main');

        return $this->render('users.list');
    }

    public function createUser(Request $request): string {
        $this->setLayout('main');

        $registerForm = new RegisterForm();
        if ($request->isPost()) {
            $registerForm->loadData($request->getBody());
            $registerForm->agreeTerms = true;
            if ($registerForm->validate() and $registerForm->register()) {
                Application::$app->session->setFlash('success', Application::t('auth', 'Register successful'));
            }
        }

        return $this->render('users.create', ['registerForm' => $registerForm]);
    }

    public function manageUser(Request $request): string {
        $this->setLayout('main');

        /** @var User $user */
        $user = User::findOne(['id' => $request->getRouteParam('id')]);

        if($request->isPost()) {
            $user->loadData($request->getBody());
            if($user->validate()) {
                $user->email_confirmed = isset($request->getBody()['email_confirmed']) ? true : $user->email_confirmed;
                $user->save();
                Application::$app->session->setFlash('success', Application::t('general', 'Update successful!'));
            }
        }

        return $this->render('users.manage', ['user' => $user]);
    }
}