<?php

namespace Changemaker\Currency\Denomination\Format;

class FormatFactory
{
    /** @var FormatInterface[] */
    private static $instances = [];

    private function __construct() {}

    public static function create(int $id, string $name_singular, string $name_plural, bool $is_physical, string $override_class_name = null)
    {
        $class_name = ($override_class_name && class_exists($override_class_name)) ? $override_class_name : Format::class;
        return self::getById($id) ?? self::$instances[$id] = new $class_name($id, $name_singular, $name_plural, $is_physical);
    }

    public static function getById(int $id): ?FormatInterface
    {
        if (isset(self::$instances[$id])) {
            return self::$instances[$id];
        }

        return null;
    }
}