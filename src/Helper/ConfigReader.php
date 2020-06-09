<?php

namespace Changemaker\Helper;

class ConfigReader
{
    protected const CONFIG_ROOT = __DIR__ . '/../../config/';

    public static function readConfig(string $name, string $field = null)
    {
        $path = self::CONFIG_ROOT . "{$name}.php";

        if (!file_exists($path) && is_readable($path)) {
            throw new \InvalidArgumentException("Cannot read config '{$name}' from '{$path}'");
        }

        $config = @include $path;

        if ($field !== null && isset($config[$field])) {            
            return $config[$field];
        }

        return $config;
    }
}