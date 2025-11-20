<?php
declare(strict_types=1);

namespace App\Utils;

class Logger
{
    public static function info(string $message): void
    {
        // Refactor candidate: ubah ke format JSON (commit refactor).
        echo "[INFO] " . date('c') . " " . $message . PHP_EOL;
    }

    public static function error(string $message): void
    {
        // Latihan Refactor: standarisasi struktur (commit refactor).
        fwrite(STDERR, "[ERROR] " . date('c') . " " . $message . PHP_EOL);
    }
}