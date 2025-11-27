<?php
declare(strict_types=1);
namespace App\utils;
final class StringHelper
{
    public static function slug(string $text): string
    {
        $t = strtolower(trim($text));
        $t = preg_replace('/[^a-z0-9]+/i', '-', $t);
        return trim((string) $t, '-');
    }
}
