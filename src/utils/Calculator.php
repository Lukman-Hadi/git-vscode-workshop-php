<?php
declare(strict_types=1);
namespace App\utils;
final class Calculator
{
    public function add(int|float $a, int|float $b): int|float { return $a + $b; }
    public function subtract(int|float $a, int|float $b): int|float { return $a - $b; }
    public function multiply(int|float $a, int|float $b): int|float { return $a * $b; }
    public function divide(int|float $a, int|float $b): float {
        if ($b == 0.0) { throw new \InvalidArgumentException('Division by zero'); }
        return $a / $b;
    }
}
