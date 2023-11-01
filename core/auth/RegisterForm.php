<?php

namespace tframe\core\auth;

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

    public function rules(): array {
        return [
            'email' => [self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => User::class], 'attribute'],
            'password' => [self::RULE_PASSWORD, [self::RULE_MIN, 'min' => 8], [self::RULE_MATCH, 'match' => 'passwordConfirmation']],
            'passwordConfirmation' => [self::RULE_PASSWORD],
        ];
    }

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

    public function register(): bool {
        $user = new User();
        $user->id = null;
        $user->email = $this->email;
        $user->firstName = $this->firstName;
        $user->lastName = $this->lastName;
        $user->password = password_hash($this->password, PASSWORD_ARGON2ID, ['memory_cost' => 65536, 'time_cost' => 4, 'threads' => 3]);
        $user->save();

        $user = User::findOne(['email' => $this->email]);

        return Application::$app->login($user);
    }
}