<?php

declare(strict_types=1);

use Quartetcom\StaticAnalysisKit\EasyCodingStandard\Config;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    Config::use($ecsConfig);

    $ecsConfig->paths(array_map(static fn (string $path) => __DIR__ . $path, [
        '/src',
        '/tests',
    ]));
};
