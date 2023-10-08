<?php

namespace tframe\common\models;

use tframe\core\database\MagicRecord;

/**
 * @property integer $id
 * @property string $roleName
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */

class Role extends MagicRecord {
    public static function tableName(): string { return 'roles'; }

    public function attributes(): array {
        return [
            'roleName',
            'description',
        ];
    }

    public function labels(): array {
        return [
            'roleName' => 'Role Name',
            'description' => 'Role description',
        ];
    }
}