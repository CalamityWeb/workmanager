<?php

namespace tframe\core\auth;

use Override;
use tframe\common\models\Users;
use tframe\core\Application;
use tframe\core\database\MagicRecord;

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
            'userId' => Application::t('attributes', 'User'),
            'roleId' => Application::t('attributes', 'Role'),
        ];
    }

    public function rules(): array {
        return [
            'userId' => [self::RULE_REQUIRED, [self::RULE_EXISTS, 'class' => Users::class], ['attribute' => 'id']],
            'roleId' => [self::RULE_REQUIRED, [self::RULE_EXISTS, 'class' => Roles::class], ['attribute' => 'id']],
        ];
    }
}