<?php

namespace tframe\core\database;

use AllowDynamicProperties;
use PDOStatement;
use tframe\core\Application;
use tframe\core\Model;

#[AllowDynamicProperties] abstract class MagicRecord extends Model {
    abstract public static function tableName(): string;

    public static function primaryKey(): string {
        return 'id';
    }

    public static function prepare($sql): PDOStatement {
        return Application::$app->db->prepare($sql);
    }

    public function save(): bool {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        if (!self::findOne([$this->primaryKey() => $this->{$this->primaryKey()}])) {
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
                if ($this->{$attribute} == null) {
                    $this->{$attribute} = 'null';
                }
                $attr = str_replace(":$attribute", $this->{$attribute}, $attr);
            }

            $attr = str_ireplace('"null"', 'null', $attr);

            $statement = self::prepare("UPDATE $tableName SET $attr WHERE " . $this->primaryKey() . " = '" . $this->{$this->primaryKey()} . "'");
        }
        return $statement->execute();
    }

    private static function getPrepare(array $where, array $order): PDOStatement {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

        $orderBy = '';
        foreach ($order as $key => $value) {
            $orderBy .= ' ORDER BY ' . $key . ' ' . $value;
        }
        if(empty($where)) {
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

    public static function findOne(array $where = [], array $order = []) {
        $statement = self::getPrepare($where, $order);
        return $statement->fetchObject(static::class);
    }

    public static function findMany(array $where = [], array $order = []): false|array {
        $statement = self::getPrepare($where, $order);
        return $statement->fetchAll();
    }

    public static function queryOne(string $tableName, string $query) {
        $statement = self::prepare("SELECT * FROM $tableName WHERE $query");
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function queryMany(string $tableName, string $query): false|array {
        $statement = self::prepare("SELECT * FROM $tableName WHERE $query");
        $statement->execute();
        return $statement->fetchAll();
    }
}