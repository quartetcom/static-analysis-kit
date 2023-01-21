<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit;

use Symfony\Component\Process\Process;

trait ProcessTtyTrait
{
    private function runInTtyOrFallback(Process $process): int
    {
        try {
            return $process
                ->setTty(true)
                ->run()
            ;
        } catch (\Exception) {
            return $process->run(function (string $type, string $buffer): void {
                $type === Process::ERR
                    ? fwrite(\STDERR, $buffer)
                    : fwrite(\STDOUT, $buffer)
                ;
            });
        }
    }
}
