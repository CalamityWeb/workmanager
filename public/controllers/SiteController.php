<?php

namespace calamity\public\controllers;

use calamity\common\models\core\Controller;

class SiteController extends Controller {
    public function index (): string {
        return $this->renderViewOnly('index');
    }
}