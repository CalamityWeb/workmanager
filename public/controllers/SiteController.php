<?php

namespace calamity\public\controllers;

use calamity\Controller;

class SiteController extends Controller {
    public function index (): string {
        return $this->renderViewOnly('index');
    }
}