<?php

namespace Utils;

class Env {
    public static function load() {
        $env = file_get_contents(__DIR__ . "/../../.env");
        $lines = explode("\n", $env);

        foreach ($lines as $line) {
            preg_match("/([^#]+)\=(.*)/", $line, $matches);
            if (isset($matches[2])) {
                $data = explode("=", trim($line));
                $key = $data[0];
                unset($data[0]);
                $value = join("=", $data);
                define($key, $value);
            }
        }
    }

    public static function __callStatic($name, $arguments)
    {
        if (defined($name)) {
            return constant($name);
        }

        return null;
    }
}