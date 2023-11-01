<?php

namespace tframe\common\models;

use tframe\core\Application;
use tframe\core\database\MagicRecord;

/**
 * @property integer $id
 * @property string $email
 * @property string $firstName
 * @property string $lastName
 * @property string $password
 * @property boolean $email_confirmed
 * @property string $created_at
 * @property string $updated_at
 */

class User extends MagicRecord {
    public static function tableName(): string {
        return "users";
    }

    public function attributes(): array {
        return [
            'email',
            'firstName',
            'lastName',
            'password',
        ];
    }

    public function labels(): array {
        return [
            'email' => Application::t('attributes','Email address'),
            'firstName' => Application::t('attributes','Family name'),
            'lastName' => Application::t('attributes','Given name'),
            'password' => Application::t('attributes','Password')
        ];
    }

    public function rules(): array {
        return [
            'email' => [self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class], 'attribute'],
        ];
    }

    public function getDisplayName(): string {
        return $this->firstName . ' ' . $this->lastName;
    }
}