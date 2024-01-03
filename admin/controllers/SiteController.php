<?php

namespace tframe\admin\controllers;

use tframe\common\models\Users;
use tframe\core\Application;
use tframe\core\Controller;
use tframe\core\Request;
use tframe\core\Response;

class SiteController extends Controller {
    public function dashboard(): string {
        $this->setLayout('main');
        $userCount = count(Users::findMany());
        return $this->render('site.dashboard', ['userCount' => $userCount]);
    }

    public function profile(Request $request, Response $response): string {
        $this->setLayout('main');
        $user = Users::findOne([Users::primaryKey() => Application::$app->session->get('sessionUser')]);
        if($request->isPost()) {
            $user->loadData($request->getBody());
            if($user->validate()) {
                $user->save();
                Application::$app->session->setFlash('success', Application::t('general', 'Update successful!'));
            }
        }
        return $this->render('site.profile', ['user' => $user]);
    }
}