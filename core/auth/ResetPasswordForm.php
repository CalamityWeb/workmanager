<?php

namespace tframe\core\auth;

use tframe\core\Application;
use tframe\core\Model;

class ResetPasswordForm extends Model {
    public ?string $password = null;
    public ?string $passwordConfirmation = null;

    public static function labels(): array {
        return [
            'password' => Application::t('attributes', 'New password'),
            'passwordConfirmation' => Application::t('attributes', 'New password confirmation'),
        ];
    }

    public function rules(): array {
        return [
            'password' => [self::RULE_REQUIRED, self::RULE_PASSWORD, [self::RULE_MIN, 'min' => 8], [self::RULE_MATCH, 'match' => 'passwordConfirmation']],
            'passwordConfirmation' => [self::RULE_REQUIRED],
        ];
    }
}