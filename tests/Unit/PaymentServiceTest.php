<?php
declare(strict_types=1);
namespace App\Tests\Unit;
use App\services\payment\Gateway;
use App\services\payment\PaymentService;
use PHPUnit\Framework\TestCase;

final class PaymentServiceTest extends TestCase
{
    public function testPayValidAmount(): void
    {
        $gateway = $this->createStub(Gateway::class);
        $gateway->method('charge')->willReturn(true);
        $service = new PaymentService($gateway);
        $this->assertTrue($service->pay(150));
    }
    public function testPayInvalidAmountThrows(): void
    {
        $gateway = $this->createStub(Gateway::class);
        $service = new PaymentService($gateway);
        $this->expectException(\InvalidArgumentException::class);
        $service->pay(0);
    }
}
