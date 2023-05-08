<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Command;

use Symfony\Component\Console\Style\SymfonyStyle;

trait InstallFileTrait
{
    private function pathSource(string $path): string
    {
        return __DIR__ . '/../..' . $path;
    }

    private function pathTarget(string $path): string
    {
        return '.' . $path;
    }

    private function installFile(string $path, ?SymfonyStyle $io = null, bool $confirmOverride = false): void
    {
        $source = $this->pathSource($path);
        $target = $this->pathTarget($path);

        if (!file_exists($directory = \dirname((string) $target))) {
            mkdir($directory, recursive: true);
        } elseif (!is_dir($directory)) {
            throw new \RuntimeException("Path '{$directory}' is not a directory.");
        }

        if ($confirmOverride && file_exists($target)
            && !$io?->confirm("File {$target} already exists. Are you sure you want to overwrite?")) {
            $io?->text("Skipped installing '{$target}'.");

            return;
        }

        file_put_contents($target, file_get_contents($source));
    }
}
