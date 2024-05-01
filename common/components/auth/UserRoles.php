<?php

namespace calamity\common\components\auth;

use calamity\common\models\core\Calamity;
use calamity\common\models\core\database\MagicRecord;
use calamity\common\models\Roles;
use calamity\common\models\Users;

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