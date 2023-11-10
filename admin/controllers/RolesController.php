<?php

namespace tframe\admin\controllers;

use tframe\core\Controller;

class RolesController extends Controller {
    public function listRoles(): string {
        $this->setLayout('main');

        return $this->render('roles.list');
    }

    public function createRole(): string {
        $this->setLayout('main');

        return $this->render('roles.create');
    }

    public function manageRole(): string {
        $this->setLayout('main');

        return $this->render('roles.manage');
    }
}