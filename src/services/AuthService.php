<?php
declare(strict_types=1);

namespace App\Services;

class AuthService
{
    public function isTokenExpired(?int $expiryMs): bool
    {
        if ($expiryMs === null) {
            return true;
        }
        return (int) (microtime(true) * 1000) > $expiryMs;
    }

    public function verifyToken(string $token): bool
    {
        if (strlen($token) < 10) {
            return false;
        }
        if (strpos($token, '.') === false) {
            return false;
        }
        return true;
    }
}