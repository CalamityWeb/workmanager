<?php

use calamity\common\models\core\Router;
use calamity\public\controllers\SiteController;

Router::get('/', [SiteController::class, 'index']);