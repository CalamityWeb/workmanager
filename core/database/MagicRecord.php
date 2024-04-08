<?php

namespace tframe\core\database;

use AllowDynamicProperties;
use PDO;
use PDOStatement;
use tframe\core\Application;
use tframe\core\Model;

#[AllowDynamicProperties] abstract class MagicRecord extends Model {
    public function __construct() {
        foreach (static::attributes() as $attribute) {
            if (!isset($this->{$attribute})) {
                $this->{$attribute} = null;
            }
        }
    }

    public static function findMany(array $where = [], array $order = []): false|array {
        return self::getPrepare($where, $order)->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    private static function getPrepare(array $where, array $order): PDOStatement {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(static fn($attr) => "$attr = :$attr", $attributes));

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
        return $statement->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public function save(): bool {
        foreach (static::attributes() as $attribute) {
            if ($this->{$attribute} === "") {
                $this->{$attribute} = null;
            }
        }

        $tableName = static::tableName();
        $attributes = static::attributes();
        $params = array_map(static fn($attr) => ":$attr", $attributes);

        if (!is_array(static::primaryKey())) {
            $exists = self::findOne([static::primaryKey() => $this->{static::primaryKey()}]);
        } else {
            $where = [];
            foreach (static::primaryKey() as $value) {
                $where[$value] = $this->{$value};
            }
            $exists = static::findOne($where);
        }

        if (!$exists) {
            $statement = self::prepare("INSERT INTO $tableName (" . implode(", ", $attributes) . ") VALUES (" . implode(",", $params) . ")");
            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }
        } else {
            $attr = '';
            for ($i = 0; $i < sizeof($attributes); $i++) {
                $attr .= $attributes[$i] . '=:' . $attributes[$i] . ', ';
            }
            $attr = substr($attr, 0, -2);

            if (is_array(static::primaryKey())) {
                $attributes = implode(" AND ", array_map(fn($key) => "$key = '" . $this->{$key} . "'", static::primaryKey()));
                $statement = self::prepare("UPDATE " . static::tableName() . " SET $attr WHERE " . $attributes);
            } else {
                $statement = self::prepare("UPDATE $tableName SET $attr WHERE " . static::primaryKey() . " = '" . $this->{static::primaryKey()} . "'");
            }

            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }
        }
        return $statement->execute();
    }

    abstract public static function primaryKey(): string|array;

    public static function findOne(array $where = [], array $order = []) {
        return self::getPrepare($where, $order)->fetchObject(static::class);
    }

    public function delete(): bool {
        if (is_array(static::primaryKey())) {
            $attributes = implode(" AND ", array_map(fn($key) => "$key = '" . $this->{$key} . "'", static::primaryKey()));
            $statement = self::prepare("DELETE FROM " . static::tableName() . " WHERE " . $attributes);
        } else {
            $statement = self::prepare("DELETE FROM " . static::tableName() . " WHERE " . static::primaryKey() . " = '" . $this->{static::primaryKey()} . "'");
        }
        return $statement->execute();
    }
}