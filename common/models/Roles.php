<?php

namespace calamity\common\models;

use calamity\common\models\core\Calamity;
use calamity\common\models\core\database\MagicRecord;

/**
 * @property int    $id
 * @property string $roleName
 * @property string $roleIcon
 * @property string $description
 * @property string $created_at
 * @property string $completed_at
 */
class Roles extends MagicRecord {
    public static function tableName(): string { return 'roles'; }

    public static function primaryKey(): string|array { return 'id'; }

    public static function attributes(): array {
        return ['roleName', 'roleIcon', 'description'];
    }

    public static function labels(): array {
        return [
            'roleName' => Calamity::t('attributes', 'Role Name'),
            'roleIcon' => Calamity::t('attributes', 'Role Icon'),
            'description' => Calamity::t('attributes', 'Description'),
        ];
    }

    public function rules(): array {
        return [
            'roleName' => [self::RULE_REQUIRED],
        ];
    }
}