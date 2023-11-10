<?php

namespace tframe\admin\controllers;

use tframe\core\Controller;

class UsersController extends Controller {
    public function listUsers(): string {
        $this->setLayout('main');

        return $this->render('users.list');
    }

    public function createUser(): string {
        $this->setLayout('main');

        return $this->render('users.create');
    }

    public function manageUser(): string {
        $this->setLayout('main');

        return $this->render('users.manage');
    }
}