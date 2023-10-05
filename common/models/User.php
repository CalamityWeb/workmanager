<?php

namespace tframe\common\models;

use tframe\core\database\MagicRecord;

class User extends MagicRecord {
    public static function tableName(): string {
        return "users";
    }
}