<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Command;

use Quartetcom\StaticAnalysisKit\PhpCsFixer\Runner;
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
        private readonly Runner $runner = new Runner(),
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
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $noRisky = (bool) $input->getOption('no-risky');
        $noRector = (bool) $input->getOption('no-rector');

        if (($exitCode = $this->phpCsFixer($io, $noRisky)) !== 0) {
            return $exitCode;
        }

        return 0;
    }

    private function phpCsFixer(SymfonyStyle $io, bool $noRisky): int
    {
        $io->title('Running php-cs-fixer '.($noRisky ? '(no risky)' : ''));

        return $this->runner->run(!$noRisky, ['--dry-run']);
    }
}
