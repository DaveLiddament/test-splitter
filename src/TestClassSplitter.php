<?php

declare(strict_types=1);

namespace DaveLiddament\TestSplitter;

final class TestClassSplitter
{
    /**
     * @var array<int,string>
     */
    private $testCaseNames;

    /** @param array<int,string> $testClassNames */
    public function __construct(array $testClassNames)
    {
        sort($testClassNames);
        $this->testCaseNames = $testClassNames;
    }

    /** @return array<int,string> */
    public function getTestCaseNames(int $set, int $of): array
    {
        $results = [];

        $setZeroIndexed = $set - 1;

        if ($setZeroIndexed < 0) {
            $setZeroIndexed = $of - 1;
        }

        foreach ($this->testCaseNames as $index => $value) {
            $remainder = $index % $of;

            if ($remainder === $setZeroIndexed) {
                $results[] = $value;
            }
        }

        return $results;
    }
}
