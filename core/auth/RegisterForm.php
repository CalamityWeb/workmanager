<?php

namespace tframe\core\auth;

use tframe\common\models\User;
use tframe\core\Model;

class RegisterForm extends Model {
    public ?string $email = null;
    public ?string $password = null;

    public function rules(): array {
        return [
            'email' => [self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => User::class], 'attribute'],
        ];
    }

    public function labels(): array {
        return [
            'email' => "Email address",
            'password' => "Password"
        ];
    }

    public function register(): bool {

    }
}