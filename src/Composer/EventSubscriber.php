<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Composer;

use Composer\EventDispatcher\EventSubscriberInterface;
use Quartetcom\StaticAnalysisKit\Application;

class EventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly Application $app = new Application(),
    ) {
    }

    /**
     * @throws \Exception
     */
    public function onUpdate(): void
    {
        $this->app
            ->setDefaultCommand('update')
            ->run()
        ;
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'post-update-cmd' => 'onUpdate',
        ];
    }
}
