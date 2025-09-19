<?php

declare(strict_types=1);

namespace DaveLiddament\TestSplitter\Tests;

use DaveLiddament\TestSplitter\CliArgumentParser;
use DaveLiddament\TestSplitter\InvalidArgumentsException;
use PHPUnit\Framework\TestCase;

final class CliArgumentParserTest extends TestCase
{
    private const SCRIPT_NAME = 'tsplit';

    /** @return array<string,array{array<int,string>}> */
    public static function invalidArgumentsDataProvider(): array
    {
        return [
            'none' => [
                [
                    self::SCRIPT_NAME,
                ],
            ],
            'too few' => [
                [
                    self::SCRIPT_NAME,
                    '1',
                ],
            ],
            'too many' => [
                [
                    self::SCRIPT_NAME,
                    '1',
                    '2',
                    '3',
                ],
            ],
            'numerator is float' => [
                [
                    self::SCRIPT_NAME,
                    '1.3',
                    '2',
                ],
            ],
            'numerator is string' => [
                [
                    self::SCRIPT_NAME,
                    'hello',
                    '2',
                ],
            ],
            'denominator is float' => [
                [
                    self::SCRIPT_NAME,
                    '1',
                    '2.9',
                ],
            ],
            'denominator is string' => [
                [
                    self::SCRIPT_NAME,
                    '2',
                    'hello',
                ],
            ],
            'numerator is negative' => [
                [
                    self::SCRIPT_NAME,
                    '-2',
                    '10',
                ],
            ],
            'denominator is negative' => [
                [
                    self::SCRIPT_NAME,
                    '2',
                    '-10',
                ],
            ],
            'numerator is zero' => [
                [
                    self::SCRIPT_NAME,
                    '0',
                    '10',
                ],
            ],
            'denominator is zero' => [
                [
                    self::SCRIPT_NAME,
                    '2',
                    '0',
                ],
            ],
            'numerator is greater than denominator' => [
                [
                    self::SCRIPT_NAME,
                    '2',
                    '1',
                ],
            ],
        ];
    }

    /**
     * @dataProvider invalidArgumentsDataProvider
     *
     * @param array<int,string> $args
     */
    public function testInvalidArguments(array $args): void
    {
        $this->expectException(InvalidArgumentsException::class);
        new CliArgumentParser($args);
    }

    /** @return array<int,array{int, int, array<int,string>}> */
    public static function validArgumentsDataProvider(): array
    {
        return [
            [
                1,
                2,
                [
                    self::SCRIPT_NAME,
                    '1',
                    '2',
                ],
            ],
        ];
    }

    /**
     * @dataProvider validArgumentsDataProvider
     *
     * @param array<int,string> $args
     */
    public function testValidArguments(int $expectedNumerator, int $expectedDenominator, array $args): void
    {
        $cliArguments = new CliArgumentParser($args);
        $this->assertSame($expectedNumerator, $cliArguments->getNumerator());
        $this->assertSame($expectedDenominator, $cliArguments->getDenominator());
    }
}
