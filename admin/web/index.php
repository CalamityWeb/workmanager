<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

use calamity\admin\controllers\AuthController;
use calamity\admin\controllers\RoutesManagement;
use calamity\admin\controllers\SiteController;
use calamity\admin\controllers\UsersController;
use calamity\Calamity;

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../common/config');
$dotenv->load();

$config = [
    'database' => [
        'host' => $_ENV['DATABASE_HOST'],
        'dbname' => $_ENV['DATABASE_DBNAME'],
        'username' => $_ENV['DATABASE_USERNAME'],
        'password' => $_ENV['DATABASE_PASSWORD'],
    ],
    'mailer' => [
        'system_address' => $_ENV['SYSTEM_EMAIL'],
        'host' => $_ENV['EMAIL_HOST'],
        'username' => $_ENV['EMAIL_USERNAME'],
        'password' => $_ENV['EMAIL_PASSWORD'],
    ],
    'maintenance' => $_ENV['ADMIN_MAINTENANCE'],
    'language' => $_ENV['ADMIN_LANGUAGE'],
    'google' => [
        'site_key' => $_ENV['GOOGLE_SITE_KEY'],
        'secret_key' => $_ENV['GOOGLE_SECRET_KEY'],
    ],
];

$app = new Calamity(dirname(__DIR__), $config);

$app->router->get('/', function() { Calamity::$app->response->redirect('/auth/login'); });

/* *Site routes */
$app->router->getNpost('/site/dashboard', [SiteController::class, 'dashboard']);
$app->router->getNpost('/site/profile', [SiteController::class, 'profile']);

/* * Authentication routes  */
$app->router->getNpost('/auth/login', [AuthController::class, 'login']);
$app->router->getNpost('/auth/register', [AuthController::class, 'register']);
$app->router->get('/auth/logout', [AuthController::class, 'logout']);
$app->router->getNpost('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
$app->router->getNpost('/auth/reset-password/{token}', [AuthController::class, 'resetPassword']);

/* * Users Management routes */
$app->router->get('/users/list-all', [UsersController::class, 'listUsers']);
$app->router->getNpost('/users/create', [UsersController::class, 'createUser']);
$app->router->get('/users/delete/{id}', [UsersController::class, 'deleteUser']);
$app->router->getNpost('/users/manage/{id}', [UsersController::class, 'manageUser']);

/* * Routes Management routes */
$app->router->get('/routes-management/items/list-all', [RoutesManagement::class, 'listItems']);
$app->router->getNpost('/routes-management/items/create', [RoutesManagement::class, 'createItem']);
$app->router->get('/routes-management/items/delete/{id}', [RoutesManagement::class, 'deleteItem']);
$app->router->getNpost('/routes-management/items/manage/{id}', [RoutesManagement::class, 'manageItem']);

$app->router->get('/routes-management/roles/list-all', [RoutesManagement::class, 'listRoles']);
$app->router->getNpost('/routes-management/roles/create', [RoutesManagement::class, 'createRole']);
$app->router->get('/routes-management/roles/delete/{id}', [RoutesManagement::class, 'deleteRole']);
$app->router->getNpost('/routes-management/roles/manage/{id}', [RoutesManagement::class, 'manageRole']);

$app->run();