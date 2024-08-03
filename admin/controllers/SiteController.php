<?php

namespace calamity\admin\controllers;

use calamity\common\helpers\CoreHelper;
use calamity\common\models\core\Calamity;
use calamity\common\models\core\Controller;
use calamity\common\models\core\Request;
use calamity\common\models\core\Response;
use calamity\common\models\Users;

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
            $user->loadData($request->getBody());
            if ($user->validate()) {
                $user->save();
                Calamity::$app->session->setFlash('success', Calamity::t('general', 'Update successful!'));
            }
        }
        return $this->render('site.profile', ['user' => $user]);
    }

    public function systeminfo(Request $request, Response $response): string {
        return $this->render('site.system-info');
    }
}