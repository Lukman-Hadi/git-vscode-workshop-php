<?php
declare(strict_types=1);
namespace App\Tests\Unit;
use App\notification\Mailer;
use App\notification\WelcomeService;
use PHPUnit\Framework\TestCase;

final class WelcomeServiceTest extends TestCase
{
    public function testWelcomeSendsEmail(): void
    {
        $mailer = $this->createMock(Mailer::class);
        $mailer->expects($this->once())
               ->method('send')
               ->with(
                   $this->equalTo('user@example.com'),
                   $this->stringContains('Welcome, user@example.com!')
               )
               ->willReturn(true);
        $service = new WelcomeService($mailer);
        $this->assertTrue($service->welcome('user@example.com'));
    }
}
