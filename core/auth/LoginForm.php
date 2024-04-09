<?php

namespace calamity\core\auth;

use calamity\common\models\Users;
use calamity\core\Calamity;
use calamity\core\Model;

class LoginForm extends Model {
    public ?string $email = null;
    public ?string $password = null;
    public bool $rememberMe = false;

    public static function labels(): array {
        return [
            'email' => Calamity::t('attributes', 'Email address'),
            'password' => Calamity::t('attributes', 'Password'),
            'rememberMe' => Calamity::t('attributes', 'Remember me'),
        ];
    }

    public function rules(): array {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function login(): bool {
        /** @var Users $user */
        $user = Users::findOne(['email' => $this->email]);

        if (!$user) {
            $this->addError('email', Calamity::t('auth', 'This email is not in our system!'));
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', Calamity::t('auth', 'The given email/password combination is not correct!'));
            return false;
        }

        if ($this->rememberMe) {
            setcookie('rememberMe', $user->id, (time() + (86400 * 7)), '/');
        }

        return Calamity::$app->login($user);
    }
}