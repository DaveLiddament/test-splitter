<?php

declare(strict_types=1);

namespace DaveLiddament\TestSplitter\Tests;

use DaveLiddament\TestSplitter\TestNameExtractor;
use PHPUnit\Framework\TestCase;

class TestNameExtractorTest extends TestCase
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
    public function dataProvider(): array
    {
        return [
            [
                self::MANY_TESTS,
                [
                    'PhpmdJsonResultsParserTest',
                    'PhpstanJsonResultsParserTest',
                    'PsalmJsonResultsParserTest',
                    'SarbJsonResultsParserTest',
                ],
            ],
            [
                " - DaveLiddament\StaticAnalysisResultsBaseliner\Tests\Unit\Plugins\ResultsParsers\SarbJsonResultsParser\SarbJsonResultsParserTest::testConversion",
                [
                    'SarbJsonResultsParserTest',
                ],
            ],
            [
                self::DUPLICATE_TEST,
                [
                    'SarbJsonResultsParserTest',
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
        $this->assertEquals(
            $expectedTestNames,
            $actual
        );
    }
}
