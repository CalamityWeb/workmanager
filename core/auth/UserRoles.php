<?php

namespace calamity\core\auth;

use Override;
use calamity\common\models\Users;
use calamity\core\Calamity;
use calamity\core\database\MagicRecord;

/**
 * @property integer $userId
 * @property integer $roleId
 * @property string  $created_at
 * @property string  $updated_at
 */
class UserRoles extends MagicRecord {
    public static function tableName(): string { return 'user_roles'; }

    public static function primaryKey(): string|array { return ['userId', 'roleId']; }

    public static function attributes(): array {
        return ['userId', 'roleId'];
    }

    public static function labels(): array {
        return [
            'userId' => Calamity::t('attributes', 'User'),
            'roleId' => Calamity::t('attributes', 'Role'),
        ];
    }

    public function rules(): array {
        return [
            'userId' => [self::RULE_REQUIRED, [self::RULE_EXISTS, 'class' => Users::class], ['attribute' => 'id']],
            'roleId' => [self::RULE_REQUIRED, [self::RULE_EXISTS, 'class' => Roles::class], ['attribute' => 'id']],
        ];
    }
}