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
            'email_confirmed',
        ];
    }

    public function labels(): array {
        return [
            'email' => Application::t('attributes','Email address'),
            'firstName' => Application::t('attributes','Given name'),
            'lastName' => Application::t('attributes','Family name'),
            'password' => Application::t('attributes','Password'),
            'email_confirmed' => Application::t('attributes','Email confirmed')
        ];
    }

    public function rules(): array {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class], 'attribute'],
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, self::RULE_PASSWORD],
        ];
    }

    public function getFullName(): string {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getUserPicture(): string {
        return file_exists('./assets/images/profile-pictures/' . $this->{$this->primaryKey()} . '.png') ? '/assets/images/profile-pictures/' . $this->{$this->primaryKey()} . '.png' : '/assets/images/user-dummy.png';
    }
}