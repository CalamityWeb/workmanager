<?php

use calamity\admin\controllers\AuthController;
use calamity\admin\controllers\RoutesManagement;
use calamity\admin\controllers\SiteController;
use calamity\admin\controllers\UsersController;
use calamity\common\models\core\Calamity;
use calamity\common\models\core\Router;

Router::get('/', function() { Calamity::$app->response->redirect('/auth/login'); });

Router::get('/system-info',[SiteController::class, 'systemInfo']);

/* *Site routes */
Router::getNpost('/site/dashboard', [SiteController::class, 'dashboard']);
Router::getNpost('/site/profile', [SiteController::class, 'profile']);

/* * Authentication routes  */
Router::getNpost('/auth/login', [AuthController::class, 'login']);
Router::getNpost('/auth/register', [AuthController::class, 'register']);
Router::get('/auth/logout', [AuthController::class, 'logout']);
Router::getNpost('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
Router::getNpost('/auth/reset-password/{token}', [AuthController::class, 'resetPassword']);
Router::getNpost('/auth/verify-account/{token}', [AuthController::class, 'verifyAccount']);
Router::get('/auth/google-auth', [AuthController::class, 'googleAuth']);

/* * Users Management routes */
Router::get('/users/list-all', [UsersController::class, 'listUsers']);
Router::getNpost('/users/create', [UsersController::class, 'createUser']);
Router::get('/users/delete/{id}', [UsersController::class, 'deleteUser']);
Router::getNpost('/users/manage/{id}', [UsersController::class, 'manageUser']);

/* * Routes Management routes */
Router::get('/routes-management/items/list-all', [RoutesManagement::class, 'listItems']);
Router::getNpost('/routes-management/items/create', [RoutesManagement::class, 'createItem']);
Router::get('/routes-management/items/delete/{id}', [RoutesManagement::class, 'deleteItem']);
Router::getNpost('/routes-management/items/manage/{id}', [RoutesManagement::class, 'manageItem']);

Router::get('/routes-management/roles/list-all', [RoutesManagement::class, 'listRoles']);
Router::getNpost('/routes-management/roles/create', [RoutesManagement::class, 'createRole']);
Router::get('/routes-management/roles/delete/{id}', [RoutesManagement::class, 'deleteRole']);
Router::getNpost('/routes-management/roles/manage/{id}', [RoutesManagement::class, 'manageRole']);