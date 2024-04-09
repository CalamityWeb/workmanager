<?php

namespace calamity\core\auth;

use calamity\common\components\text\Generator;
use calamity\common\models\Users;
use calamity\core\Calamity;
use calamity\core\Model;

class RegisterForm extends Model {
    public ?string $email = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $password = null;
    public ?string $passwordConfirmation = null;
    public bool $agreeTerms = false;

    public static function labels(): array {
        return [
            'email' => Calamity::t('attributes', 'Email address'),
            'firstName' => Calamity::t('attributes', 'Given name'),
            'lastName' => Calamity::t('attributes', 'Family name'),
            'password' => Calamity::t('attributes', 'Password'),
            'passwordConfirmation' => Calamity::t('attributes', 'Password confirmation'),
            'agreeTerms' => Calamity::t('attributes', 'I agree to the terms'),
        ];
    }

    public function rules(): array {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => Users::class], 'attribute'],
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, self::RULE_PASSWORD, [self::RULE_MIN, 'min' => 8], [self::RULE_MATCH, 'match' => 'passwordConfirmation']],
            'passwordConfirmation' => [self::RULE_REQUIRED],
            'agreeTerms' => [self::RULE_REQUIRED],
        ];
    }

    public function register(): Users {
        $user = new Users();
        $user->id = null;
        $user->email = $this->email;
        $user->firstName = $this->firstName;
        $user->lastName = $this->lastName;
        $user->password = password_hash($this->password, PASSWORD_ARGON2ID, ['memory_cost' => 65536, 'time_cost' => 4, 'threads' => 3]);
        $user->email_confirmed = false;
        $user->save();

        return Users::findOne(['email' => $this->email]);
    }
}