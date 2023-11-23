<?php

namespace tframe\admin\controllers;

use tframe\common\models\User;
use tframe\core\Application;
use tframe\core\Controller;
use tframe\core\Request;

class UsersController extends Controller {
    public function listUsers(): string {
        $this->setLayout('main');

        return $this->render('users.list');
    }

    public function createUser(): string {
        $this->setLayout('main');

        return $this->render('users.create');
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