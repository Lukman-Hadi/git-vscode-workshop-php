<?php
declare(strict_types=1);

namespace App\Utils;

class EmailValidator
{
    private static array $whitelist = ['example.com', 'workshop.dev'];

    public static function isValid(string $email): bool
    {
        if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email)) {
            return false;
        }
        $domain = substr(strrchr($email, '@'), 1);
        return in_array(strtolower($domain), self::$whitelist, true);
    }
}