<?php

namespace J4kim\Merzi;

class Auth
{
    public static function attempt(string $passphrase): bool
    {
        $strConfig = file_get_contents("../config.json");
        $config = json_decode($strConfig);
        return $config->passphrase === $passphrase;
    }

    public static function login(string $passphrase): bool
    {
        $correct = self::attempt($passphrase);
        return $_SESSION['authenticated'] = $correct;
    }

    public static function logout(): bool
    {
        return session_destroy();
    }

    public static function check(): bool
    {
        return isset($_SESSION['authenticated']) && $_SESSION['authenticated'];
    }
}