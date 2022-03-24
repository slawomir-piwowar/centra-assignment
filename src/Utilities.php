<?php
declare(strict_types=1);

namespace KanbanBoard;

/**
 * @deprecated
 */
class Utilities
{
    private function __construct()
    {
    }

    public static function env($name, $default = NULL)
    {
        return $_ENV[$name];
    }

    public static function hasValue($array, $key)
    {
        return is_array($array) && array_key_exists($key, $array) && !empty($array[$key]);
    }
}
