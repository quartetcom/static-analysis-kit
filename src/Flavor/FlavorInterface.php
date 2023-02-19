<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Flavor;

interface FlavorInterface
{
    public static function create(): self;

    public function name(): string;

    /**
     * @return array<string, null|string>
     */
    public function devDependencies(): array;
}
