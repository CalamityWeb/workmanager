<?php

namespace tframe\admin\controllers;

use tframe\core\Controller;

class RoutesManagement extends Controller {

    public function index(): string {
        $this->setLayout('main');

        return $this->render('routes-management.index');
    }

}