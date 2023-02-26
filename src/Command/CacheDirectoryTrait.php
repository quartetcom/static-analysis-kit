<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Command;

trait CacheDirectoryTrait
{
    protected static string $cacheDirectoryPath = './.cache';

    protected function ensureCacheDirectory(): void
    {
        if (!file_exists(static::$cacheDirectoryPath)) {
            mkdir(static::$cacheDirectoryPath);
        }
    }
}
