<?php

namespace tframe\core\auth;

use tframe\core\database\MagicRecord;

/**
 * @property string $code
 * @property string $description
 * @property string $created_at
 * @property string $completed_at
 */


class AuthItem extends MagicRecord {

    public static function tableName(): string { return 'auth_items'; }

    public static function primaryKey(): string { return 'code'; }

    public function attributes(): array {
        return [ 'code', 'description' ];
    }

    public function labels(): array {
        return [
            'code' => 'Route (URL)',
            'description' => 'Description',
        ];
    }

    public function rules(): array {
        return [
            'code' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class], 'attribute'],
        ];
    }
}