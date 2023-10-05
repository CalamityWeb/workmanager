<?php

namespace tframe\admin\controllers;

use tframe\core\Controller;

class SiteController extends Controller {
    public function index(): string {
        return $this->renderViewOnly('index');
    }
}