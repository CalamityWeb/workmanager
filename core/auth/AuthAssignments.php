<?php

namespace tframe\core\auth;

use tframe\core\database\MagicRecord;

/**
 * @property string $code
 * @property integer $item
 * @property string $created_at
 * @property string $completed_at
 */
class AuthAssignments extends MagicRecord {

    public static function tableName(): string { return 'auth_assignments'; }

    public static function primaryKey(): string|array { return ['code', 'item']; }

    public function attributes(): array {
        return [ 'code', 'item' ];
    }

    public function labels(): array {
        return [
            'code' => 'Group code',
            'item' => 'Route (URL)'
        ];
    }

    public function rules(): array {
        return [
            'code' => [self::RULE_REQUIRED, [self::RULE_EXISTS, 'class' => AuthGroup::class]],
            'item' => [self::RULE_REQUIRED, [self::RULE_EXISTS, 'class' => AuthItem::class], ['attribute' => 'id']]
        ];
    }
}