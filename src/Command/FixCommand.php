<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Command;

use Quartetcom\StaticAnalysisKit\EasyCodingStandard\Runner as EcsRunner;
use Quartetcom\StaticAnalysisKit\PhpCsFixer\Runner as PhpCsFixerRunner;
use Quartetcom\StaticAnalysisKit\Rector\Runner as RectorRunner;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('fix')]
class FixCommand extends Command
{
    use CacheDirectoryTrait;

    public function __construct(
        private readonly EcsRunner $ecsRunner = new EcsRunner(),
        private readonly PhpCsFixerRunner $phpCsFixerRunner = new PhpCsFixerRunner(),
        private readonly RectorRunner $rectorRunner = new RectorRunner(),
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Tries to fix code automatically.')
            ->addOption(
                'no-ecs',
                mode: InputOption::VALUE_NONE,
                description: 'Runs an analysis using PHP-CS-Fixer instead of EasyCodingStandard.',
            )
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

        $noEcs = (bool) $input->getOption('no-ecs');
        $risky = (bool) $input->getOption('risky');
        $rector = (bool) $input->getOption('rector');

        $this->ensureCacheDirectory();

        if (($exitCode = $this->rector($io, $rector)) !== 0) {
            return $exitCode;
        }

        $io->newLine(2);

        if ($noEcs) {
            if (($exitCode = $this->phpCsFixer($io, $risky)) !== 0) {
                return $exitCode;
            }
        } elseif (($exitCode = $this->ecs($io, $risky)) !== 0) {
            return $exitCode;
        }

        return 0;
    }

    private function ecs(SymfonyStyle $io, bool $risky): int
    {
        $io->title('Running ecs');

        if ($risky) {
            $io->warning([
                'Automatically fix with risky rules may cause a code breaking.',
                'You must confirm the changes are correct after run.',
            ]);

            if (!$io->confirm('Are you sure you want to continue?')) {
                return 1;
            }
        }

        return $this->ecsRunner->run($risky, ['--fix']);
    }

    private function phpCsFixer(SymfonyStyle $io, bool $risky): int
    {
        $io->title('Running php-cs-fixer');

        if ($risky) {
            $io->warning([
                'Automatically fix with risky rules may cause a code breaking.',
                'You must confirm the changes are correct after run.',
            ]);

            if (!$io->confirm('Are you sure you want to continue?')) {
                return 1;
            }
        }

        return $this->phpCsFixerRunner->run($risky);
    }

    private function rector(SymfonyStyle $io, bool $rector): int
    {
        $io->title('Running rector');

        if ($rector) {
            $io->warning([
                'Automatically fix with rector enabled may cause a code breaking.',
                'You must confirm the changes are correct after run.',
            ]);

            if (!$io->confirm('Are you sure you want to continue?')) {
                return 1;
            }
        } else {
            $io->text('Skipped. (If you want to use rector, run again with `--rector` flag.)');

            return 0;
        }

        return $this->rectorRunner->run();
    }
}
