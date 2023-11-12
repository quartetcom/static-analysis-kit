<?php

declare(strict_types=1);

use Quartetcom\StaticAnalysisKit\Rector\Config;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    Config::use($rectorConfig);

    $rectorConfig->paths(array_map(static fn (string $path) => __DIR__ . $path, [
        '/src',
        '/tests',
    ]));
};
