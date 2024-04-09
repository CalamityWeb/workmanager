<?php

namespace calamity\admin\controllers;

use calamity\common\models\Users;
use calamity\core\Calamity;
use calamity\core\Controller;
use calamity\core\Request;
use calamity\core\Response;

class SiteController extends Controller {
    public function dashboard (): string {
        $this->setLayout('main');
        $user = Users::findOne([Users::primaryKey() => Calamity::$app->session->get('sessionUser')]);
        $userCount = count(Users::findMany());
        return $this->render('site.dashboard', ['user' => $user, 'userCount' => $userCount]);
    }

    public function profile (Request $request, Response $response): string {
        $this->setLayout('main');
        $user = Users::findOne([Users::primaryKey() => Calamity::$app->session->get('sessionUser')]);
        if ($request->isPost()) {
            print_r($_POST);
            exit();
            $user->loadData($request->getBody());
            if ($user->validate()) {
                $user->save();
                Calamity::$app->session->setFlash('success', Calamity::t('general', 'Update successful!'));
            }
        }
        return $this->render('site.profile', ['user' => $user]);
    }
}