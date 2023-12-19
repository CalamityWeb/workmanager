<?php

namespace tframe\core\database;

use AllowDynamicProperties;
use PDOStatement;
use tframe\common\components\form\SelectField;
use tframe\core\Application;
use tframe\core\Model;

#[AllowDynamicProperties] abstract class MagicRecord extends Model {
    public function __construct() {
        foreach ($this->attributes() as $attribute) {
            if (!isset($this->{$attribute})) {
                $this->{$attribute} = null;
            }
        }
    }

    public static function findMany(array $where = [], array $order = []): false|array {
        $statement = self::getPrepare($where, $order);
        return $statement->fetchAll();
    }

    private static function getPrepare(array $where, array $order): PDOStatement {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

        $orderBy = '';
        foreach ($order as $key => $value) {
            $orderBy .= ' ORDER BY ' . $key . ' ' . $value;
        }
        if (empty($where)) {
            $statement = empty($order) ? self::prepare("SELECT * FROM $tableName") : self::prepare("SELECT * FROM $tableName $orderBy");
        } else {
            $statement = empty($order) ? self::prepare("SELECT * FROM $tableName WHERE $sql") : self::prepare("SELECT * FROM $tableName WHERE $sql $orderBy");
        }

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement;
    }

    abstract public static function tableName(): string;

    public static function prepare($sql): PDOStatement {
        return Application::$app->db->prepare($sql);
    }

    public static function queryOne(string $tableName, string $query) {
        $statement = self::prepare("SELECT * FROM $tableName WHERE $query");
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function queryMany(string $where, string $order): false|array {
        if (empty($where)) {
            $statement = empty($order) ? self::prepare("SELECT * FROM " . static::tableName()) : self::prepare("SELECT * FROM " . static::tableName() . " ORDER BY $order");
        } else {
            $statement = empty($order) ? self::prepare("SELECT * FROM " . static::tableName() . " WHERE $where") : self::prepare("SELECT * FROM " . static::tableName() . " WHERE $where ORDER BY $order");
        }

        $statement->execute();
        return $statement->fetchAll();
    }

    public function save(): bool {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        foreach ($attributes as $attribute) {
            if (is_bool($this->{$attribute})) {
                $this->{$attribute} = ($this->{$attribute}) ? 1 : 0;
            }
        }

        if (!is_array($this->primaryKey())) {
            $exists = self::findOne([$this->primaryKey() => $this->{$this->primaryKey()}]);
        } else {
            $where = [];
            foreach ($this->primaryKey() as $value) {
                $where[$value] = $this->{$value};
            }
            $exists = self::findOne($where);
        }

        if (!$exists) {
            $statement = self::prepare("INSERT INTO $tableName (" . implode(", ", $attributes) . ") VALUES (" . implode(",", $params) . ")");
            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }
        } else {
            $attr = '';
            for ($i = 0; $i < sizeof($attributes); $i++) {
                $attr .= $attributes[$i] . '="' . $params[$i] . '", ';
            }
            $attr = substr($attr, 0, -2);

            foreach ($attributes as $attribute) {
                $attr = preg_replace('/:' . $attribute . '\b/', $this->{$attribute}, $attr);
            }

            if (is_array($this->primaryKey())) {
                $attributes = implode(" AND ", array_map(fn($key) => "$key = '" . $this->{$key} . "'", $this->primaryKey()));
                $statement = self::prepare("UPDATE " . $this->tableName() . " SET $attr WHERE " . $attributes);
            } else {
                $statement = self::prepare("UPDATE $tableName SET $attr WHERE " . $this->primaryKey() . " = '" . $this->{$this->primaryKey()} . "'");
            }
        }
        return $statement->execute();
    }

    abstract public static function primaryKey(): string|array;

    public static function findOne(array $where = [], array $order = []) {
        $statement = self::getPrepare($where, $order);
        return $statement->fetchObject(static::class);
    }

    public function delete(): bool {
        if (is_array($this->primaryKey())) {
            $attributes = implode(" AND ", array_map(fn($key) => "$key = '" . $this->{$key} . "'", $this->primaryKey()));
            $statement = self::prepare("SELECT FROM " . $this->tableName() . " WHERE " . $attributes);
        } else {
            $statement = self::prepare("DELETE FROM " . $this->tableName() . " WHERE " . $this->primaryKey() . " = '" . $this->{$this->primaryKey()} . "'");
        }
        return $statement->execute();
    }
}