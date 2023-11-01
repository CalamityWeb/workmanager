<?php

namespace tframe\core\auth;

use tframe\common\models\User;
use tframe\core\Application;
use tframe\core\Model;

class LoginForm extends Model {

    public ?string $email = null;
    public ?string $password = null;
    public bool $rememberMe = false;

    public function labels(): array {
        return [
            'email' => Application::t('attributes', 'Email address'),
            'password' => Application::t('attributes','Password'),
            'rememberMe' => Application::t('attributes','Remember me')
        ];
    }

    public function login(): bool {
        /** @var User $user */
        $user = User::findOne(['email' => $this->email]);

        if (!$user) {
            $this->addError('email', Application::t('auth', 'This email is not in our system!'));
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', Application::t('auth', 'The given email/password combination is not correct!'));
            return false;
        }

        if ($this->rememberMe) {
            setcookie('rememberMe', $user->id, (time() + 86400), '/', Application::$URL['ADMIN']);
        }

        return Application::$app->login($user);
    }

}