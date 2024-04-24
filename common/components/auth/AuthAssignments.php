<?php

namespace calamity\common\components\auth;

use calamity\common\models\core\Calamity;
use calamity\common\models\core\database\MagicRecord;
use calamity\common\models\Roles;

/**
 * @property int     $role
 * @property integer $item
 * @property string  $created_at
 * @property string  $completed_at
 */
class AuthAssignments extends MagicRecord {
    public static function tableName(): string { return 'auth_assignments'; }

    public static function primaryKey(): string|array { return ['role', 'item']; }

    public static function attributes(): array {
        return ['role', 'item'];
    }

    public static function labels(): array {
        return [
            'role' => Calamity::t('attributes', 'Role'),
            'item' => Calamity::t('attributes', 'Route (URL)'),
        ];
    }

    public function rules(): array {
        return [
            'role' => [self::RULE_REQUIRED, [self::RULE_EXISTS, 'class' => Roles::class], ['attribute' => 'id']],
            'item' => [self::RULE_REQUIRED, [self::RULE_EXISTS, 'class' => AuthItem::class], ['attribute' => 'id']],
        ];
    }
}