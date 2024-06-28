<?php

namespace Utils;

use Main\Application;

class Globals {
    public static function app(): Application | null {
        return $GLOBALS['application'];
    }

    public static function __callStatic($name, $arguments)
    {
        if (isset($GLOBALS[$name])) {
            return $GLOBALS[$name];
        }

        return null;
    }
}