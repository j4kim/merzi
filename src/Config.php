<?php

namespace J4kim\Merzi;

class Config
{
    private static $configOject;

    public static function loadConfig()
    {
        if (!isset(self::$configOject)) {
            $strConfig = file_get_contents("../config.json");
            self::$configOject = json_decode($strConfig);
        }
    }

    public static function __callStatic($property, $arguments)
    {
        self::loadConfig();
        return self::$configOject->$property;
    }

    public static function store($settings)
    {
        self::loadConfig();
        $merged = array_merge((array) self::$configOject, $settings);
        file_put_contents("../config.json", json_encode($merged, JSON_PRETTY_PRINT));
    }
}
