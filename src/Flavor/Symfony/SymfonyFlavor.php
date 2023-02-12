<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Flavor\Symfony;

use Quartetcom\StaticAnalysisKit\Flavor\FlavorInterface;

class SymfonyFlavor implements FlavorInterface
{
    public static function create(): self
    {
        return new self();
    }

    public function name(): string
    {
        return 'Symfony';
    }

    public function devDependencies(): array
    {
        return [
            'phpstan/extension-installer' => null,
            'phpstan/phpstan-symfony' => null,
        ];
    }
}
