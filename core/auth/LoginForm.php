<?php

namespace tframe\core\auth;

use tframe\common\models\User;
use tframe\core\Application;
use tframe\core\Model;

class LoginForm extends Model {

    public ?string $email = null;
    public ?string $password = null;

    public function labels(): array {
        return [
            'email' => "Email address",
            'password' => "Password"
        ];
    }

    public function login(): bool {
        /** @var User $user */
        $user = User::findOne(['email' => $this->email]);

        if(!$user) {
            $this->addError('email', 'This email is not in our system!');
            return false;
        }
        if(!password_verify($this->password, $user->password)) {
            $this->addError('password', 'The given email/password combination is not correct!');
            return false;
        }

        return Application::$app->login($user);
    }

}