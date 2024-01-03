<?php

namespace tframe\core\auth;

use tframe\common\components\text\Generator;
use tframe\common\models\User;
use tframe\core\Application;
use tframe\core\Model;

class RegisterForm extends Model {
    public ?string $email = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $password = null;
    public ?string $passwordConfirmation = null;
    public bool $agreeTerms = false;

    public function labels(): array {
        return [
            'email' => Application::t('attributes','Email address'),
            'firstName' => Application::t('attributes','Given name'),
            'lastName' => Application::t('attributes','Family name'),
            'password' => Application::t('attributes','Password'),
            'passwordConfirmation' => Application::t('attributes','Password confirmation'),
            'agreeTerms' => Application::t('attributes','I agree to the terms')
        ];
    }

    public function rules(): array {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => User::class], 'attribute'],
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, self::RULE_PASSWORD, [self::RULE_MIN, 'min' => 8], [self::RULE_MATCH, 'match' => 'passwordConfirmation']],
            'passwordConfirmation' => [self::RULE_REQUIRED],
            'agreeTerms' => [self::RULE_REQUIRED],
        ];
    }

    public function register(): User {
        $user = new User();
        $user->id = null;
        $user->email = $this->email;
        $user->firstName = $this->firstName;
        $user->lastName = $this->lastName;
        $user->password = password_hash($this->password, PASSWORD_ARGON2ID, ['memory_cost' => 65536, 'time_cost' => 4, 'threads' => 3]);
        $user->email_confirmed = false;
        $user->token = Generator::randomString(User::class, 'token', 32);
        $user->save();

        return User::findOne(['email' => $this->email]);
    }
}