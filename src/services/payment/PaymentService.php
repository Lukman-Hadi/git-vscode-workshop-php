<?php
declare(strict_types=1);
namespace App\services\payment;
final class PaymentService
{
    public function __construct(private Gateway $gateway) {}
    public function pay(int $amount): bool
    {
        if ($amount <= 0) { throw new \InvalidArgumentException('Invalid amount'); }
        return $this->gateway->charge($amount);
    }
}
