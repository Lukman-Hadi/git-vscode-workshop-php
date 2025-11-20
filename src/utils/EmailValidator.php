<?php
declare(strict_types=1);

namespace App\Utils;

class EmailValidator
{
    public static function isValid(string $email): bool
    {
        return (bool) preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email);
    }

    // Latihan Fitur: tambahkan whitelist domain (commit feat).
    // Formatting Prettier/PHP CS Fixer: jadikan commit terpisah (chore).
}