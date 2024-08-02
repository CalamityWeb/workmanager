<?php

namespace calamity\common\models\core;

use calamity\common\components\mailer\Mailer;
use calamity\common\components\text\Generator;
use calamity\common\helpers\CoreHelper;
use calamity\common\models\core\database\Database;
use calamity\common\models\core\exception\Error;
use calamity\common\models\Users;
use Exception;

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
    public static array $config;
    public string $csrf;

    public function __construct($rootDir, $config) {
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

        $this->mailer = new Mailer($config['mailer']);

        try {
            $this->db = new Database($config['database']);
        } catch (Exception $e) {
            Error::sendErrorEmail($e);
            echo $this->router->renderViewOnly('@common.error', [
                'exception' => $e,
            ]);
        }

        if (isset($config['google'])) {
            self::$config['google'] = $config['google'];
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

        $this->setCSRF();
    }

    public function logout(): void {
        $this->user = null;
        self::$app->session->set('sessionUser', 0);
        unset($_COOKIE['rememberMe']);
        setcookie('rememberMe', 'null', 0, '/');
        self::$app->response->redirect('/');
    }

    public static function isGuest(): bool {
        return !self::$app->user;
    }

    public static function t(string $type, string $message) {
        $file = require(CoreHelper::getAlias('@common') . '/messages/' . self::$app->language . '/' . $type . '.php');
        return (array_key_exists($message, $file)) ? $file[$message] : $message;
    }

    public function login(Users $user): true {
        $this->user = $user;
        self::$app->session->set('sessionUser', $user->{Users::primaryKey()});
        return true;
    }

    public function run(): void {
        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
        try {
            echo $this->router->resolve();
        } catch (Exception $e) {
            Error::sendErrorEmail($e);
            echo $this->router->renderViewOnly('@common.error', [
                'exception' => $e,
            ]);
        }
    }

    public function triggerEvent($eventName): void {
        $callbacks = $this->eventListeners[$eventName] ?? [];
        foreach ($callbacks as $callback) {
            $callback();
        }
    }

    public function on($eventName, $callback): void {
        $this->eventListeners[$eventName][] = $callback;
    }

    private function setCSRF() {
        $site = null;

        $host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
        if($host == Calamity::$URL['@admin']) {
            $site = 'admin';
        } elseif($host == Calamity::$URL['@public']) {
            $site = 'public';
        }

        if(Calamity::$app->user) {
            $salt = hash('md5', Calamity::$app->user->email);
        } else {
            $salt = hash('md5',$_SERVER['HTTP_USER_AGENT'] . $_SERVER['HTTP_SEC_CH_UA']);
        }

        $this->csrf = $site . '_' . hash('sha256', $host);
    }
}