<?php

namespace tframe\core\auth;

use tframe\common\models\Users;
use tframe\core\Application;
use tframe\core\Model;

class LoginForm extends Model {
    public ?string $email = null;
    public ?string $password = null;
    public bool $rememberMe = false;

    public function labels (): array {
        return [
            'email' => Application::t('attributes', 'Email address'),
            'password' => Application::t('attributes', 'Password'),
            'rememberMe' => Application::t('attributes', 'Remember me'),
        ];
    }

    public function rules (): array {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function login (): bool {
        /** @var Users $user */
        $user = Users::findOne(['email' => $this->email]);

        if (!$user) {
            $this->addError('email', Application::t('auth', 'This email is not in our system!'));
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', Application::t('auth', 'The given email/password combination is not correct!'));
            return false;
        }

        if ($this->rememberMe) {
            setcookie('rememberMe', $user->id, (time() + (86400 * 7)));
        }

        return Application::$app->login($user);
    }
}