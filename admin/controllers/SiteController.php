<?php

namespace calamity\admin\controllers;

use calamity\common\helpers\CoreHelper;
use calamity\common\models\Users;
use calamity\Calamity;
use calamity\Controller;
use calamity\Request;
use calamity\Response;

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
            if (isset($request->getBody()['g-recaptcha-response'])) {
                $captcha = CoreHelper::validateGoogleCaptcha($request->getBody()['g-recaptcha-response']);
            } else {
                $captcha = true;
            }
            if ($user->validate() and $captcha) {
                $user->save();
                Calamity::$app->session->setFlash('success', Calamity::t('general', 'Update successful!'));
            }
            if (!$captcha) {
                Calamity::$app->session->setFlash('error', Calamity::t('general', 'Captcha validation failed!'));
            }
        }
        return $this->render('site.profile', ['user' => $user]);
    }
}