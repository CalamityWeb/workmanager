<?php

namespace tframe\core\auth;

use tframe\core\database\MagicRecord;

class AuthGroup extends MagicRecord {

    public static function tableName(): string { return 'auth_groups'; }

    public static function primaryKey(): string { return 'code'; }

    public function attributes(): array {
        return [ 'code', 'groupName', 'description' ];
    }

    public function labels(): array {
        return [
            'code' => 'Group code',
            'groupName' => 'Group name',
            'description' => 'Description',
        ];
    }

    public function rules(): array {
        return [
            'code' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class], 'attribute'],
            'groupName' => [self::RULE_REQUIRED]
        ];
    }
}