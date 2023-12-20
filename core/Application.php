<?php

namespace tframe\core;

use tframe\common\components\mailer\Mailer;
use tframe\common\helpers\CoreHelper;
use tframe\common\models\User;
use tframe\core\database\Database;
use Exception;

class Application {
    const EVENT_BEFORE_REQUEST = 'beforeRequest';
    const EVENT_AFTER_REQUEST = 'afterRequest';

    protected array $eventListeners = [];

    public static Application $app;
    public static string $ROOT_DIR;
    public string $layout = 'main';
    public Router $router;
    public Request $request;
    public Response $response;
    public ?Controller $controller = null;
    public Database $db;
    public Mailer $mailer;
    public Session $session;
    public View $view;
    public ?User $user;

    public static array $URL;
    public static array $GLOBALS;
    public bool $maintenance;
    public string $language;

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
            'PUBLIC' => $_ENV['PUBLIC_URL'],
            'ADMIN' => $_ENV['ADMIN_URL']
        ];

        $this->maintenance = strtolower($config['maintenance']) == 'true';

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

        $userId = Application::$app->session->get('sessionUser');
        if ($userId) {
            $user = User::findOne([User::primaryKey() => $userId]);
            if($user) {
                $this->user = $user;
            } else {
                $this->logout();
            }
        }
    }

    public static function isGuest(): bool {
        return !self::$app->user;
    }

    public function login(User $user): true {
        $this->user = $user;
        Application::$app->session->set('sessionUser', $user->{User::primaryKey()});
        return true;
    }

    public function canRoute(string $url): bool {

        return false;
    }

    public function logout(): void {
        $this->user = null;
        Application::$app->session->set('sessionUser', 0);
        unset($_COOKIE['rememberMe']);
        setcookie('rememberMe', 'null', 0);
        Application::$app->response->redirect('/');
    }

    public function run(): void {
        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
        try {
            echo $this->router->resolve();
        } catch (Exception $e) {
            echo $this->router->renderViewOnly('@common.error', [
                'exception' => $e,
            ]);
        }
    }

    public function triggerEvent($eventName): void {
        $callbacks = $this->eventListeners[$eventName] ?? [];
        foreach ($callbacks as $callback) {
            call_user_func($callback);
        }
    }

    public function on($eventName, $callback): void {
        $this->eventListeners[$eventName][] = $callback;
    }

    public static function t(string $type, string $message) {
        $file = require (CoreHelper::getAlias('@common') . 'messages/' . Application::$app->language . '/' . $type . '.php');
        return (array_key_exists($message, $file)) ? $file[$message] : $message;
    }
}