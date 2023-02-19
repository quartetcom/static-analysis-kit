<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit;

use Quartetcom\StaticAnalysisKit\Command\AnalyseCommand;
use Quartetcom\StaticAnalysisKit\Command\FixCommand;
use Quartetcom\StaticAnalysisKit\Command\InstallCommand;
use Quartetcom\StaticAnalysisKit\Command\UpdateCommand;
use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('Static Analysis Kit for PHP');

        $this->add(new AnalyseCommand());
        $this->add(new FixCommand());
        $this->add(new InstallCommand());
        $this->add(new UpdateCommand());
    }
}
