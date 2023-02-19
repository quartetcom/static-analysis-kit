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

    /**
     * @throws \JsonException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $configPath = $this->pathTarget('/.static-analysis-kit.json');

        /** @var array{ignore?: list<string>} $config */
        $config = json_decode(@file_get_contents($configPath) ?: '{}', true, flags: \JSON_THROW_ON_ERROR);

        /** @var list<string> $ignore */
        $ignore = $config['ignore'] ?? [];

        foreach (self::$files as $path) {
            if (!file_exists($target = $this->pathTarget($path))) {
                continue;
            }

            if (file_get_contents($this->pathSource($path)) === file_get_contents($target)) {
                continue;
            }

            if (\in_array($path, $ignore, true)) {
                continue;
            }

            if (!$io->confirm("File '{$path}' is updated in static-analysis-kit. Do you want to update yours too?")) {
                $ignore[] = $path;

                continue;
            }

            $this->installFile($path, $io);
        }

        $config['ignore'] = $ignore;
        file_put_contents(
            $configPath,
            json_encode($config, flags: \JSON_THROW_ON_ERROR | \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES),
        );

        $io->success('Your configuration files looks shine!');

        return 0;
    }
}
