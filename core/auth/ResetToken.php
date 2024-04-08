<?php

namespace tframe\core\auth;

use tframe\core\database\MagicRecord;

/**
 * @property string  $token
 * @property integer $userId
 * @property string  $created_at
 * @property string  $completed_at
 */
class ResetToken extends MagicRecord {
    public static function tableName(): string {
        return 'reset_tokens';
    }

    public static function primaryKey(): string {
        return 'token';
    }

    public static function attributes(): array {
        return ['token', 'userId', 'completed_at'];
    }

    public static function labels(): array {
        return [
            'token' => "Token",
            'userId' => "User",
        ];
    }

    public function rules(): array {
        return [];
    }
}