<?php

namespace tframe\common\models;

use tframe\core\database\MagicRecord;

class Role extends MagicRecord {
    public static function tableName(): string { return 'roles'; }
}