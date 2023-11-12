<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Flavor;

class FlavorAggregate
{
    /**
     * @param FlavorInterface[] $flavors
     */
    public function __construct(
        private readonly array $flavors = [],
    ) {
    }

    /**
     * @param class-string<FlavorInterface>[] $classNames
     */
    public static function fromClassNames(array $classNames): self
    {
        return new self(array_map(
            static fn (string $className): FlavorInterface => [$className, 'create'](),
            $classNames,
        ));
    }

    /**
     * @return string[]
     */
    public function names(): array
    {
        return array_map(
            static fn (FlavorInterface $flavor): string => $flavor->name(),
            $this->flavors,
        );
    }

    /**
     * @return array<string, null|string>
     */
    public function devDependencies(): array
    {
        $deps = [];

        foreach ($this->flavors as $flavor) {
            $deps = [...$deps, ...$flavor->devDependencies()];
        }

        return $deps;
    }
}
