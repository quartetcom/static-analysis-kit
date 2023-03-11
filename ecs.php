<?php

declare(strict_types=1);

use Quartetcom\StaticAnalysisKit\EasyCodingStandard\Config;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return function (ECSConfig $ecsConfig): void {
    Config::use($ecsConfig);

    $ecsConfig->paths(array_map(fn (string $path) => __DIR__ . $path, [
        '/src',
        '/tests',
    ]));
};
