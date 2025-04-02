<?php

namespace J4kim\Merzi;

class Config
{
    private static $configOject;

    public static function loadConfig() {
        if (!isset(self::$configOject)) {
            $strConfig = file_get_contents("../config.json");
            self::$configOject = json_decode($strConfig);
        }
    }

    public static function __callStatic($property, $arguments) {
        self::loadConfig();
        return self::$configOject->$property;
    }
}