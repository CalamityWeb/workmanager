<?php

namespace calamity\common\components\auth;

use calamity\common\models\core\Calamity;
use calamity\common\models\core\Model;

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