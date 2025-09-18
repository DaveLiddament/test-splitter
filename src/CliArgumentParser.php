<?php

declare(strict_types=1);

namespace DaveLiddament\TestSplitter;

final class CliArgumentParser
{
    /**
     * @var int
     */
    private $numerator;
    /**
     * @var int
     */
    private $denominator;

    /** @param array<int,string> $args */
    public function __construct(array $args)
    {
        if (3 !== count($args)) {
            throw new InvalidArgumentsException('Invalid number of arguments given');
        }

        $this->numerator = $this->asInt($args[1]);
        $this->denominator = $this->asInt($args[2]);

        if ($this->numerator > $this->denominator) {
            throw new InvalidArgumentsException("Numerator must be less than Demoninator ({$this->denominator})");
        }
    }

    public function getNumerator(): int
    {
        return $this->numerator;
    }

    public function getDenominator(): int
    {
        return $this->denominator;
    }

    private function asInt(string $value): int
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentsException('Arguments must be integer values');
        }

        $asInt = (int) $value;

        $possibleIntAsString = (string) $asInt;

        if ($possibleIntAsString !== $value) {
            throw new InvalidArgumentsException('Arguments must be integer values');
        }

        if ($asInt <= 0) {
            throw new InvalidArgumentsException('Arguments must be positive integer values');
        }

        return $asInt;
    }
}
