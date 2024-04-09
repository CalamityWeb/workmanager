<?php

namespace calamity\core;

use Exception;
use calamity\common\components\mailer\Mailer;
use calamity\common\helpers\CoreHelper;
use calamity\common\models\Users;
use calamity\core\database\Database;

class Calamity {
    const EVENT_BEFORE_REQUEST = 'beforeRequest';
    const EVENT_AFTER_REQUEST = 'afterRequest';
    public static Calamity $app;
    public static string $ROOT_DIR;
    public static array $URL;
    public static array $GLOBALS;
    public string $layout = 'main';
    public Router $router;
    public Request $request;
    public Response $response;
    public ?Controller $controller = null;
    public Database $db;
    public Mailer $mailer;
    public Session $session;
    public View $view;
    public ?Users $user;
    public bool $maintenance;
    public string $language;
    protected array $eventListeners = [];

    public function __construct ($rootDir, $config) {
        $this->user = null;
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        $this->view = new View();

        self::$URL = [
            '@public' => $_ENV['PUBLIC_URL'],
            '@admin' => $_ENV['ADMIN_URL'],
        ];

        $this->maintenance = strtolower($config['maintenance']) === 'true';

        $this->language = $config['language'];

        foreach (require CoreHelper::getAlias('@common') . '/config/globals.php' as $key => $value) {
            self::$GLOBALS[$key] = $value;
        }

        try {
            $this->db = new Database($config['database']);
            $this->mailer = new Mailer($config['mailer']);
        } catch (Exception $e) {
            echo $this->router->renderViewOnly('@common.error', [
                'exception' => $e,
            ]);
        }

        $userId = self::$app->session->get('sessionUser');
        if ($userId) {
            $user = Users::findOne([Users::primaryKey() => $userId]);
            if ($user) {
                $this->user = $user;
            } else {
                $this->logout();
            }
        }
    }

    public function logout (): void {
        $this->user = null;
        self::$app->session->set('sessionUser', 0);
        unset($_COOKIE['rememberMe']);
        setcookie('rememberMe', 'null', 0);
        self::$app->response->redirect('/');
    }

    public static function isGuest (): bool {
        return !self::$app->user;
    }

    public static function t (string $type, string $message) {
        $file = require(CoreHelper::getAlias('@common') . 'messages/' . self::$app->language . '/' . $type . '.php');
        return (array_key_exists($message, $file)) ? $file[$message] : $message;
    }

    public function login (Users $user): true {
        $this->user = $user;
        self::$app->session->set('sessionUser', $user->{Users::primaryKey()});
        return true;
    }

    public function run (): void {
        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
        try {
            echo $this->router->resolve();
        } catch (Exception $e) {
            echo $this->router->renderViewOnly('@common.error', [
                'exception' => $e,
            ]);
        }
    }

    public function triggerEvent ($eventName): void {
        $callbacks = $this->eventListeners[$eventName] ?? [];
        foreach ($callbacks as $callback) {
            $callback();
        }
    }

    public function on ($eventName, $callback): void {
        $this->eventListeners[$eventName][] = $callback;
    }
}