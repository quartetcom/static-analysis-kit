<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Phpstan;

use Symfony\Component\Process\Process;

class Runner
{
    /**
     * @param list<string> $command
     */
    public function __construct(
        private readonly array $command = ['php', './vendor/bin/phpstan'],
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
