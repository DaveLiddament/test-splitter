<?php

declare(strict_types=1);

namespace DaveLiddament\TestSplitter\Tests;

use DaveLiddament\TestSplitter\TestNameExtractor;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class TestNameExtractorTest extends TestCase
{
    private const DUPLICATE_TEST = <<<EOL
- DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\SarbJsonResultsParser\SarbJsonResultsParserTest::testIdentifier
- DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\SarbJsonResultsParser\SarbJsonResultsParserTest::testConversion
EOL;

    private const MANY_TESTS = <<<EOL
PHPUnit 9.0.0 by Sebastian Bergmann and contributors.

Available test(s):

 - DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\PhpmdJsonResultsParser\PhpmdJsonResultsParserTest::testGetIdentifier
 - DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\PhpstanJsonResultsParser\PhpstanJsonResultsParserTest::testConversionFromString
 - DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\PsalmJsonResultsParser\PsalmJsonResultsParserTest::testInvalidFileFormat#3
 - DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\SarbJsonResultsParser\SarbJsonResultsParserTest::testConversion
 - DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\SarbJsonResultsParser\SarbJsonResultsParserTest::testTypeGuesser
 - DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\SarbJsonResultsParser\SarbJsonResultsParserTest::testInvalidJsonInput
EOL;

    /** @return array<int,array{string,array<int,string>}> */
    public static function dataProvider(): array
    {
        return [
            [
                self::MANY_TESTS,
                [
                    'DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\PhpmdJsonResultsParser\PhpmdJsonResultsParserTest',
                    'DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\PhpstanJsonResultsParser\PhpstanJsonResultsParserTest',
                    'DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\PsalmJsonResultsParser\PsalmJsonResultsParserTest',
                    'DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\SarbJsonResultsParser\SarbJsonResultsParserTest',
                ],
            ],
            [
                " - DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\SarbJsonResultsParser\SarbJsonResultsParserTest::testConversion",
                [
                    'DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\SarbJsonResultsParser\SarbJsonResultsParserTest',
                ],
            ],
            [
                self::DUPLICATE_TEST,
                [
                    'DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\SarbJsonResultsParser\SarbJsonResultsParserTest',
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     *
     * @param array<int,string> $expectedTestNames
     */
    public function testNameExtractor(string $input, array $expectedTestNames): void
    {
        $testNameExtractor = new TestNameExtractor();
        $actual = $testNameExtractor->getDeDupedTestClassNames($input);
        Assert::assertEquals(
            $expectedTestNames,
            $actual
        );
    }
}
