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
            $lastSlashPosition = strrpos($line, '\\');
            if (false === $lastSlashPosition) {
                continue;
            }

            $testCase = substr($line, $lastSlashPosition + 1);

            $firstColonPosition = strrpos($testCase, '::');
            if (false === $firstColonPosition) {
                continue;
            }

            $testName = substr($testCase, 0, $firstColonPosition);

            if (!in_array($testName, $testNames)) {
                $testNames[] = $testName;
            }
        }

        return $testNames;
    }
}
