<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('install')]
class InstallCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setDescription('Installs this kit to your project interactively.')
        ;
    }

    /**
     * @throws \JsonException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Welcome to quartetcom/static-analysis-kit!');

        if ($io->confirm('First, we will add the default configurations of analysis tools for you. Is it okay?')) {
            $this->installAnalysisDefaults($io);
        }

        if ($io->confirm(
            'Are you using using IntelliJ IDEA or PhpStorm? We have a brief configuration for them.',
        )) {
            $this->installIntellijSettings($io);
        }

        if (!file_exists('./.circleci/config.yml') &&
            $io->confirm('Are you using CircleCI? We will add .circleci/config.yml for you.')) {
            $this->installCircleCiWorkflow($io);
        }

        if (!file_exists('./.github/workflows/php.yml') &&
            $io->confirm('Are you using GitHub Actions? We will add .github/workflows/php.yml for you.')) {
            $this->installGitHubActionsWorkflow($io);
        }

        if ($io->confirm(
            'Last question. Do you want to run analysis using simple commands? We will modify your composer.json for you.',
        )) {
            $this->modifyComposerJson($io);
        }

        return 0;
    }

    private function installAnalysisDefaults(SymfonyStyle $io): void
    {
        $files = [
            '/.php-cs-fixer.dist.php',
            '/phpstan.neon',
            '/rector.php',
        ];

        foreach ($files as $file) {
            $this->installFile($file, $io, true);
        }

        $io->success('Successfully installed analysis defaults.');
    }

    private function installIntellijSettings(SymfonyStyle $io): void
    {
        $files = [
            '/.idea/codeStyles/codeStyleConfig.xml',
            '/.idea/codeStyles/Project.xml',
            '/.idea/inspectionProfiles/profiles_settings.xml',
            '/.idea/inspectionProfiles/quartetcom.xml',
        ];

        foreach ($files as $file) {
            $this->installFile($file);
        }

        $io->success('Successfully installed IntelliJ settings.');
    }

    private function installCircleCiWorkflow(SymfonyStyle $io): void
    {
        $this->installFile('/.circleci/config.yml');

        $io->success('Successfully installed a CircleCI workflow.');
    }

    private function installGitHubActionsWorkflow(SymfonyStyle $io): void
    {
        $this->installFile('/.github/workflows/php.yml');

        $io->success('Successfully installed a GitHub Actions workflow.');
    }

    /**
     * @throws \JsonException
     */
    private function modifyComposerJson(SymfonyStyle $io): void
    {
        $path = '/composer.json';
        $source = __DIR__ . '/../..' . $path;
        $target = '.' . $path;

        $ignore = [
            'post-autoload-dump',
        ];

        $sourceJson = json_decode(file_get_contents($source), true, flags: JSON_THROW_ON_ERROR);
        $targetJson = json_decode(file_get_contents($target), true, flags: JSON_THROW_ON_ERROR);

        foreach (['scripts', 'scripts-descriptions'] as $group) {
            if (!isset($targetJson[$group])) {
                $targetJson[$group] = [];
            }

            foreach ($sourceJson[$group] as $key => $value) {
                if (!in_array($key, $ignore)) {
                    $targetJson[$group][$key] = $value;
                }
            }
        }

        file_put_contents(
            $target,
            json_encode($targetJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n",
        );

        $io->success([
            'Successfully modified your composer.json.',
            'DO NOT FORGET RUNNING `composer update --lock`.',
        ]);
    }

    private function installFile(string $path, ?SymfonyStyle $io = null, bool $confirmOverride = false): void
    {
        $source = __DIR__ . '/../..' . $path;
        $target = '.' . $path;

        if (!file_exists($directory = dirname($target))) {
            mkdir($directory);
        } elseif (!is_dir($directory)) {
            throw new \RuntimeException("Path '$directory' is not a directory.");
        }

        if ($confirmOverride && file_exists($target) &&
            !$io?->confirm("File {$target} already exists. Are you sure you want to overwrite?")) {
            $io?->text("Skipped installing '{$target}'.");

            return;
        }

        file_put_contents($target, file_get_contents($source));
    }
}
