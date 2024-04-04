<?php

namespace tframe\core\auth;

use tframe\core\Application;
use tframe\core\database\MagicRecord;

/**
 * @property int    $id
 * @property string $roleName
 * @property string $roleIcon
 * @property string $description
 * @property string $created_at
 * @property string $completed_at
 */
class Roles extends MagicRecord {
    public static function tableName (): string { return 'roles'; }

    public static function primaryKey (): string|array { return 'id'; }

    public function attributes (): array {
        return ['roleName', 'roleIcon', 'description'];
    }

    public function labels (): array {
        return [
            'roleName' => Application::t('attributes', 'Role Name'),
            'roleIcon' => Application::t('attributes', 'Role Icon'),
            'description' => Application::t('attributes', 'Description'),
        ];
    }

    public function rules (): array {
        return [
            'roleName' => [self::RULE_REQUIRED],
        ];
    }
}