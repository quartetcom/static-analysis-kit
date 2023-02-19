<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface
{
    public function __construct(
        private readonly EventSubscriber $eventSubscriber = new EventSubscriber(),
    ) {
    }

    public function activate(Composer $composer, IOInterface $io): void
    {
        $composer->getEventDispatcher()->addSubscriber($this->eventSubscriber);
        $io->info('static-analysis-kit has been activated successfully.');
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
    }
}
