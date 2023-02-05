<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Command;

use Quartetcom\StaticAnalysisKit\PhpCsFixer\Runner as PhpCsFixerRunner;
use Quartetcom\StaticAnalysisKit\Phpstan\Runner as PhpstanRunner;
use Quartetcom\StaticAnalysisKit\Rector\Runner as RectorRunner;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('analyse')]
class AnalyseCommand extends Command
{
    public function __construct(
        private readonly PhpCsFixerRunner $phpCsFixerRunner = new PhpCsFixerRunner(),
        private readonly RectorRunner $rectorRunner = new RectorRunner(),
        private readonly PhpstanRunner $phpstanRunner = new PhpstanRunner(),
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Runs an analysis with the configured rules (dry-run).')
            ->addOption(
                'no-risky',
                mode: InputOption::VALUE_NONE,
                description: 'Runs an analysis without any risky rules.',
            )
            ->addOption(
                'no-rector',
                mode: InputOption::VALUE_NONE,
                description: 'Runs an analysis without rector enabled.',
            )
            ->addOption(
                'no-phpstan',
                mode: InputOption::VALUE_NONE,
                description: 'Runs an analysis without phpstan enabled.',
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $noRisky = (bool) $input->getOption('no-risky');
        $noRector = (bool) $input->getOption('no-rector');
        $noPhpstan = (bool) $input->getOption('no-phpstan');

        if (($exitCode = $this->rector($io, $noRector)) !== 0) {
            return $exitCode;
        }

        $io->newLine(2);

        if (($exitCode = $this->phpstan($io, $noPhpstan)) !== 0) {
            return $exitCode;
        }

        $io->newLine(2);

        if (($exitCode = $this->phpCsFixer($io, $noRisky)) !== 0) {
            return $exitCode;
        }

        return 0;
    }

    private function phpCsFixer(SymfonyStyle $io, bool $noRisky): int
    {
        $io->title('Running php-cs-fixer');

        if ($noRisky) {
            $io->warning([
                'Analysing without risky rules is not recommended.',
                'Your configured CI may fail if you commit without analysing fully.',
            ]);
        }

        return $this->phpCsFixerRunner->run(!$noRisky, ['--dry-run']);
    }

    private function rector(SymfonyStyle $io, bool $noRector): int
    {
        $io->title('Running rector');

        if ($noRector) {
            $io->warning([
                'Analysing with rector disabled is not recommended.',
                'Your configured CI may fail if you commit without analysing fully.',
            ]);

            return 0;
        }

        return $this->rectorRunner->run(['--dry-run']);
    }

    private function phpstan(SymfonyStyle $io, bool $noPhpstan): int
    {
        $io->title('Running PHPStan');

        if ($noPhpstan) {
            $io->warning([
                'Analysing with phpstan disabled is not recommended.',
                'Your configured CI may fail if you commit without analysing fully.',
            ]);

            return 0;
        }

        return $this->phpstanRunner->run();
    }
}
