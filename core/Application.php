<?php

namespace tframe\core;

use tframe\common\components\mailer\Mailer;
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

    public array $URL;

    public function __construct($rootDir, $config) {

        $this->user = null;
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        $this->view = new View();

        $this->URL = [
            'PUBLIC' => $_ENV['PUBLIC_URL'],
            'ADMIN' => $_ENV['ADMIN_URL']
        ];

        try {
            $this->db = new Database($config['database']);
            $this->mailer = new Mailer($config['mailer']);
        } catch (Exception $e) {
            echo $this->router->renderViewOnly('@common.error', [
                'exception' => $e,
            ]);
        }

        $userId = Application::$app->session->get('userId');
        if ($userId) {
            $this->user = User::findOne([User::primaryKey() => $userId]);
        }
    }

    public static function isGuest(): bool {
        return !self::$app->user;
    }

    public function login(User $user): true {
        $this->user = $user;
        $primaryKey = User::primaryKey();
        Application::$app->session->set('userId', $user->{$primaryKey});

        return true;
    }

    public function logout(): void {
        $this->user = null;
        self::$app->session->remove('userId');
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
}