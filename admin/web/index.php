<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

use tframe\admin\controllers\AuthController;
use tframe\admin\controllers\RoutesManagement;
use tframe\admin\controllers\SiteController;
use tframe\admin\controllers\UsersController;
use tframe\core\Application;

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../common/config');
$dotenv->load();

$config = [
    'database' => [
        'host' => $_ENV['DATABASE_HOST'],
        'dbname' => $_ENV['DATABASE_DBNAME'],
        'username' => $_ENV['DATABASE_USERNAME'],
        'password' => $_ENV['DATABASE_PASSWORD']
    ],
    'mailer' => [
        'system_address' => $_ENV['SYSTEM_EMAIL'],
        'host' => $_ENV['EMAIL_HOST'],
        'username' => $_ENV['EMAIL_USERNAME'],
        'password' => $_ENV['EMAIL_PASSWORD']
    ],
    'maintenance' => $_ENV['ADMIN_MAINTENANCE'],
    'language' => $_ENV['ADMIN_LANGUAGE']
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'index']);

/* * Authentication routes  */
$app->router->getNpost('/auth/login', [AuthController::class, 'login']);
$app->router->getNpost('/auth/register', [AuthController::class, 'register']);
$app->router->get('/auth/logout', [AuthController::class, 'logout']);
$app->router->getNpost('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
$app->router->getNpost('/auth/reset-password/{token}', [AuthController::class, 'resetPassword']);

/* * Users Management routes */
$app->router->get('/users/list-all', [UsersController::class, 'listUsers']);
$app->router->getNpost('/users/create', [UsersController::class, 'createUser']);
$app->router->getNpost('/users/manage/{id}', [UsersController::class, 'manageUser']);

/* * Routes Management routes */
$app->router->get('/routes-management/items/list-all', [RoutesManagement::class, 'listItems']);
$app->router->getNpost('/routes-management/items/create', [RoutesManagement::class, 'createItem']);
$app->router->getNpost('/routes-management/items/manage/{id}', [RoutesManagement::class, 'manageItem']);

$app->router->get('/routes-management/roles/list-all', [RoutesManagement::class, 'listRoles']);
$app->router->getNpost('/routes-management/roles/create', [RoutesManagement::class, 'createRole']);
$app->router->getNpost('/routes-management/roles/manage/{id}', [RoutesManagement::class, 'manageRole']);

$app->run();