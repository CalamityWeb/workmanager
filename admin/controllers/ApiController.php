<?php

namespace tframe\admin\controllers;

use tframe\common\models\User;
use tframe\core\Application;
use tframe\core\Controller;
use tframe\core\exception\UnauthorizedException;

class ApiController extends Controller {

    private function checkLogged(): void {
        if(Application::isGuest()) {
            throw new UnauthorizedException();
        }
    }

    public function listUsers(): false|string {
        $this->checkLogged();
        $users = User::findMany();
        return json_encode($users);
    }
}