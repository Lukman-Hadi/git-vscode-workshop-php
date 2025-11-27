<?php
declare(strict_types=1);
namespace App\services\payment;
interface Gateway { public function charge(int $amount): bool; }
