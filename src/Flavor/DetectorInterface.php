<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Flavor;

interface DetectorInterface
{
    public function detect(string $path): bool;

    /**
     * @return class-string<FlavorInterface>
     */
    public function flavor(): string;
}
