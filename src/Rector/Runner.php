<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Rector;

use Symfony\Component\Process\Process;

class Runner
{
    public function __construct(
        private readonly array $command = ['php', './vendor/bin/rector', 'process'],
    ) {
    }

    /**
     * @param list<string> $additionalArguments
     */
    public function run(array $additionalArguments = []): int
    {
        return (new Process([...$this->command, ...$additionalArguments]))
            ->setTty(true)
            ->run()
        ;
    }
}
