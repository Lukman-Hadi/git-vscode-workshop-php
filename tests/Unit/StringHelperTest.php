<?php
declare(strict_types=1);
namespace App\Tests\Unit;
use App\utils\StringHelper;
use PHPUnit\Framework\TestCase;

final class StringHelperTest extends TestCase
{
    public function testSlugSimple(): void
    {
        $this->assertSame('hello-world', StringHelper::slug('Hello World!'));
    }
    public function testSlugTrimsDashes(): void
    {
        $this->assertSame('a-b-c', StringHelper::slug('---A  B  C---'));
    }
    /**
     * @dataProvider slugProvider
     */
    public function testSlugProvider(string $in, string $out): void
    {
        $this->assertSame($out, StringHelper::slug($in));
    }
    public static function slugProvider(): array
    {
        return [
            ['  PHP Unit Testing  ', 'php-unit-testing'],
            ['@Special#Chars$', 'special-chars'],
            ['Multiple   Spaces', 'multiple-spaces'],
        ];
    }
}
