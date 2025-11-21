<?php

declare(strict_types=1);

namespace DaveLiddament\TestSplitter\Tests;

use DaveLiddament\TestSplitter\TestClassSplitter;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class TestCaseSplitterTest extends TestCase
{
    private const ONE = 'A';
    private const TWO = 'B';
    private const THREE = 'C';
    private const FOUR = 'D';
    private const FIVE = 'E';
    private const SIX = 'F';

    /** @return array<int,array{int, int, array<int,string>}> */
    public static function dataProvider(): array
    {
        return [
            [
                1,
                1,
                [
                    self::ONE,
                    self::TWO,
                    self::THREE,
                    self::FOUR,
                    self::FIVE,
                    self::SIX,
                ],
            ],
            [
                1,
                2,
                [
                    self::ONE,
                    self::THREE,
                    self::FIVE,
                ],
            ],
            [
                2,
                2,
                [
                    self::TWO,
                    self::FOUR,
                    self::SIX,
                ],
            ],
            [
                7,
                7,
                [
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     *
     * @param array<int,string> $expectedTests
     */
    public function testSplittingTests(int $set, int $of, array $expectedTests): void
    {
        $testCaseSplitter = new TestClassSplitter([
            self::FIVE,
            self::FOUR,
            self::ONE,
            self::THREE,
            self::TWO,
            self::SIX,
        ]);

        $actual = $testCaseSplitter->getTestCaseNames($set, $of);

        Assert::assertEquals($expectedTests, $actual);
    }
}
