<?php

namespace tframe\public\controllers;

use tframe\core\Controller;

class SiteController extends Controller {
    public function index(): string {
        return $this->renderViewOnly('index');
    }
}