<?php

namespace calamity\common\models;

use calamity\common\models\core\Calamity;
use calamity\common\models\core\database\MagicRecord;

/**
 * @property int    $id
 * @property string $name
 * @property string $icon
 * @property string $description
 * @property int    $level
 * @property string $created_at
 * @property string $completed_at
 */
class Roles extends MagicRecord {
    public static function tableName(): string { return 'roles'; }

    public static function primaryKey(): string|array { return 'id'; }

    public static function attributes(): array {
        return ['name', 'icon', 'description', 'level'];
    }

    public static function labels(): array {
        return [
            'name' => Calamity::t('attributes', 'Role Name'),
            'icon' => Calamity::t('attributes', 'Role Icon'),
            'description' => Calamity::t('attributes', 'Description'),
            'level' => Calamity::t('attributes', 'Level'),
        ];
    }

    public function rules(): array {
        return [
            'name' => [self::RULE_REQUIRED],
        ];
    }
}