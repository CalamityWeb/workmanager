<?php

namespace calamity\core\auth;

use calamity\core\Calamity;
use calamity\core\Model;

class ResetPasswordForm extends Model {
    public ?string $password = null;
    public ?string $passwordConfirmation = null;

    public static function labels(): array {
        return [
            'password' => Calamity::t('attributes', 'New password'),
            'passwordConfirmation' => Calamity::t('attributes', 'New password confirmation'),
        ];
    }

    public function rules(): array {
        return [
            'password' => [self::RULE_REQUIRED, self::RULE_PASSWORD, [self::RULE_MIN, 'min' => 8], [self::RULE_MATCH, 'match' => 'passwordConfirmation']],
            'passwordConfirmation' => [self::RULE_REQUIRED],
        ];
    }
}