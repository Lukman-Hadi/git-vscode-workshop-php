<?php
declare(strict_types=1);
namespace App\Tests\Unit;
use App\utils\Calculator;
use PHPUnit\Framework\TestCase;

final class CalculatorTest extends TestCase
{
    private Calculator $calc;
    protected function setUp(): void { $this->calc = new Calculator(); }

    public function testAdd(): void
    {
        $this->assertSame(5, $this->calc->add(2, 3));
        $this->assertSame(3.5, $this->calc->add(1.5, 2.0));
    }
    public function testSubtract(): void { $this->assertSame(1, $this->calc->subtract(3, 2)); }
    public function testMultiply(): void { $this->assertSame(6, $this->calc->multiply(2, 3)); }
    public function testDivide(): void { $this->assertSame(2.0, $this->calc->divide(6, 3)); }

    public function testDivideByZeroThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Division by zero');
        $this->calc->divide(1, 0);
    }
    /**
     * @dataProvider addProvider
     */
    public function testAddProvider(int|float $a, int|float $b, int|float $expected): void
    {
        $this->assertSame($expected, $this->calc->add($a, $b));
    }
    public static function addProvider(): array
    {
        return [[1,2,3],[0,0,0],[-1,1,0],[1.5,2.5,4.0]];
    }
}
