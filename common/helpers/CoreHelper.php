<?php

namespace calamity\common\helpers;

class CoreHelper {
    public static function checkAlias ($string): bool {
        return str_contains($string, '@');
    }

    public static function getAlias ($string): string {
        $aliases = require dirname(__DIR__) . '/config/aliases.php';

        foreach ($aliases as $alias => $value) {
            $string = str_replace($alias, $value, $string);
        }

        return $string;
    }

    public static function listAliases (): array {
        $return = [];
        foreach (require dirname(__DIR__) . '/config/aliases.php' as $alias => $dir) {
            $return[] = $alias;
        }
        return $return;
    }
}