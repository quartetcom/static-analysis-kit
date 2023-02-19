<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Flavor\Symfony;

use Quartetcom\StaticAnalysisKit\Flavor\DetectorInterface;

class SymfonyDetector implements DetectorInterface
{
    public function detect(string $path): bool
    {
        if (($json = file_get_contents($path . '/composer.json')) === false) {
            return false;
        }

        try {
            $composerJson = json_decode($json, true, flags: \JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return false;
        }

        return \is_array($composerJson)
            && isset($composerJson['require'])
            && \is_array($require = $composerJson['require'])
            && isset($require['symfony/framework-bundle']);
    }

    public function flavor(): string
    {
        return SymfonyFlavor::class;
    }
}
