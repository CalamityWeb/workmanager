<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

use tframe\api\controllers\SiteController;
use tframe\core\Application;

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
    'maintenance' => $_ENV['API_MAINTENANCE'],
    'language' => $_ENV['API_LANGUAGE'],
];

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    die();
}

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'index']);

/* * API routes */
$app->router->get('/users/list', [SiteController::class, 'usersListUsers']);
$app->router->get('/routes-management/items/list', [SiteController::class, 'routesManagementItemsListItems']);
$app->router->get('/routes-management/roles/list', [SiteController::class, 'routesManagementListRoles']);

$app->run();