<?php

declare(strict_types=1);

namespace App\Tests\Unit\ValueObject;

use App\ValueObject\Civility;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group ValueObject
 */
final class CivilityTest extends KernelTestCase
{
    /**
     * @dataProvider provideDataSuccess
     */
    public function testCanBeCreated(array $data): void
    {
        $civility = new Civility($data['civility']);
        self::assertSame($data['civility'], (string)$civility);
    }

    /**
     * @dataProvider provideDataFail
     */
    public function testCantBeCreatedWithInvalidValue(array $data): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Civility($data['civility']);
    }

    /**
     * @dataProvider provideDataSuccess
     */
    public function testReturnStringValueIsAString(array $data): void
    {
        $civility = new Civility($data['civility']);
        self::assertIsString((string)$civility);
    }

    public function provideDataSuccess(): iterable
    {
        yield 'Valid civility value "M"' => [
            ['civility' => 'M'],
        ];
        yield 'Valid civility value "Mlle"' => [
            ['civility' => 'Mlle'],
        ];
        yield 'Valid civility value "Mme"' => [
            ['civility' => 'Mme'],
        ];
    }

    public function provideDataFail(): iterable
    {
        yield 'Invalid civility value "Monsieur"' => [
            ['civility' => 'Monsieur'],
        ];
        yield 'Invalid civility value "Madame"' => [
            ['civility' => 'Madame'],
        ];
        yield 'Invalid civility value "Mademoiselle"' => [
            ['civility' => 'Mademoiselle'],
        ];
    }
}