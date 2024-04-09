<?php

namespace calamity\core\auth;

use calamity\core\Calamity;
use calamity\core\database\MagicRecord;

/**
 * @property int    $id
 * @property string $item
 * @property string $description
 * @property string $created_at
 * @property string $completed_at
 */
class AuthItem extends MagicRecord {
    public static function tableName(): string { return 'auth_items'; }

    public static function primaryKey(): string|array { return 'id'; }

    public static function attributes(): array {
        return ['item', 'description'];
    }

    public static function labels(): array {
        return [
            'item' => Calamity::t('attributes', 'Route (URL)'),
            'description' => Calamity::t('attributes', 'Description'),
        ];
    }

    public function rules(): array {
        return [
            'item' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class], 'attribute'],
        ];
    }

    public function validateAliases(): bool {
        if (!str_contains($this->item, '@admin') and !str_contains($this->item, '@public')) {
            $this->addError('item', Calamity::t('auth', 'Route must contains the aliases of the sites. Please see below!'));
            return false;
        }

        return true;
    }
}