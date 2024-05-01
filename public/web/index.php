<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

use calamity\common\models\core\Calamity;
use calamity\public\controllers\SiteController;

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
        'support_address' => $_ENV['SUPPORT_EMAIL'],
        'system_address' => $_ENV['SYSTEM_EMAIL'],
        'host' => $_ENV['EMAIL_HOST'],
        'username' => $_ENV['EMAIL_USERNAME'],
        'password' => $_ENV['EMAIL_PASSWORD'],
    ],
    'maintenance' => $_ENV['PUBLIC_MAINTENANCE'],
    'language' => $_ENV['PUBLIC_LANGUAGE'],
    'google' => [
        'captcha_site_key' => $_ENV['GOOGLE_CAPTCHA_SITE_KEY'],
        'captcha_secret_key' => $_ENV['GOOGLE_CAPTCHA_SECRET_KEY'],
    ],
];

$app = new Calamity(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'index']);

$app->run();