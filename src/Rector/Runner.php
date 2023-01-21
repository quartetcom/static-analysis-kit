<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Rector;

use Quartetcom\StaticAnalysisKit\ProcessTtyTrait;
use Symfony\Component\Process\Process;

class Runner
{
    use ProcessTtyTrait;

    /**
     * @param list<string> $command
     */
    public function __construct(
        private readonly array $command = ['php', './vendor/bin/rector', 'process'],
    ) {
    }

    /**
     * @param list<string> $additionalArguments
     */
    public function run(array $additionalArguments = []): int
    {
        return $this->runInTtyOrFallback(new Process([...$this->command, ...$additionalArguments]));
    }
}
