<?php
declare(strict_types=1);

namespace App\Utils;

class Logger
{
    public static function info(string $message, array $context = []): void
    {
        echo "[INFO] " . date('c') . " " . $message . (!empty($context) ? ' ' . json_encode($context) : '') . PHP_EOL;
    }

    public static function error(string $message, array $context = []): void
    {
        $payload = [
            'level' => 'error',
            'timestamp' => date('c'),
            'message' => $message,
            'context' => $context,
        ];
        fwrite(STDERR, json_encode($payload, JSON_UNESCAPED_SLASHES) . PHP_EOL);
    }
}