<?php

declare(strict_types=1);

namespace DaveLiddament\TestSplitter;

final class TestNameExtractor
{
    /**
     * @return array<int,string>
     */
    public function getDeDupedTestClassNames(string $input): array
    {
        $testNames = [];
        foreach (explode(\PHP_EOL, $input) as $line) {
            $listPosition = strpos($line, '- ');
            if (false === $listPosition) {
                continue;
            }

            $testCase = substr($line, $listPosition + 2);

            $firstColonPosition = strrpos($testCase, '::');
            if (false === $firstColonPosition) {
                continue;
            }

            $testName = substr($testCase, 0, $firstColonPosition);

            if (!in_array($testName, $testNames, true)) {
                $testNames[] = $testName;
            }
        }

        return $testNames;
    }
}
