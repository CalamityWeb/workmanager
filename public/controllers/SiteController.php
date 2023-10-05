<?php

namespace tframe\public\controllers;

use tframe\core\Controller;

class SiteController extends Controller {
    public function index(): string {
        $this->layout = 'main';
        return $this->render('site.index');
    }
}