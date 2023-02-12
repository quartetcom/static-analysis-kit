<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Flavor;

class DetectorAggregate
{
    /**
     * @param DetectorInterface[] $detectors
     */
    public function __construct(
        private readonly array $detectors = [],
    ) {
    }

    /**
     * @return class-string<FlavorInterface>[]
     */
    public function detectAll(string $path): array
    {
        $flavors = [];

        foreach ($this->detectors as $detector) {
            if ($detector->detect($path)) {
                $flavors[] = $detector->flavor();
            }
        }

        return $flavors;
    }
}
