<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('update')]
class UpdateCommand extends Command
{
    use InstallFileTrait;

    /**
     * @var list<string>
     */
    private static array $files = [
        '/.php-cs-fixer.dist.php',
        '/phpstan.neon',
        '/rector.php',
        '/.idea/codeStyles/codeStyleConfig.xml',
        '/.idea/inspectionProfiles/quartetcom.xml',
    ];

    protected function configure(): void
    {
        $this
            ->setDescription('Updates configuration files provided by this kit.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach (self::$files as $path) {
            if (!file_exists($target = $this->pathTarget($path))) {
                continue;
            }

            if (file_get_contents($this->pathSource($path)) === file_get_contents($target)) {
                continue;
            }

            if (!$io->confirm("File '{$path}' is updated in static-analysis-kit. Do you want to update yours too?")) {
                continue;
            }

            $this->installFile($path, $io);
        }

        $io->success('Your configuration files looks shine!');

        return 0;
    }
}
