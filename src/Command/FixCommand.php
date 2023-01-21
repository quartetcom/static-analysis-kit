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

#[AsCommand('fix')]
class FixCommand extends Command
{
    public function __construct(
        private readonly Runner $runner = new Runner(),
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Tries to fix code automatically.')
            ->addOption(
                'risky',
                mode: InputOption::VALUE_NONE,
                description: 'Runs an analysis with risky rules.',
            )
            ->addOption(
                'rector',
                mode: InputOption::VALUE_NONE,
                description: 'Runs an analysis with rector enabled.',
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $risky = (bool) $input->getOption('risky');
        $rector = (bool) $input->getOption('rector');

        if (($exitCode = $this->phpCsFixer($io, $risky)) !== 0) {
            return $exitCode;
        }

        return 0;
    }

    private function phpCsFixer(SymfonyStyle $io, bool $risky): int
    {
        $io->title('Running php-cs-fixer '.($risky ? '(RISKY)' : ''));

        if ($risky) {
            $io->warning([
                'Automatically fix with risky rules may cause a code breaking.',
                'You must confirm the changes are correct after run.',
            ]);

            if (!$io->confirm('Are you sure you want to continue?')) {
                return 1;
            }
        }

        return $this->runner->run($risky, []);
    }
}
