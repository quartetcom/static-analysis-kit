<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Rector;

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\Config\RectorConfig;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Php81\Rector\ClassConst\FinalizePublicClassConstantRector;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SensiolabsSetList;
use Rector\Symfony\Set\SymfonySetList;

class Config
{
    /**
     * @throws ShouldNotHappenException
     */
    public static function use(RectorConfig $rectorConfig): void
    {
        $rectorConfig->sets([
            SetList::CODE_QUALITY,
            SetList::DEAD_CODE,
            SetList::TYPE_DECLARATION,
            LevelSetList::UP_TO_PHP_81,
            PHPUnitLevelSetList::UP_TO_PHPUNIT_90,
            DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES,
            SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES,
            SensiolabsSetList::ANNOTATIONS_TO_ATTRIBUTES,
        ]);

        $rectorConfig->skip([
            FinalizePublicClassConstantRector::class,
        ]);

        $rectorConfig->importNames();
        $rectorConfig->importShortClasses(false);

        $rectorConfig->cacheClass(FileCacheStorage::class);
        $rectorConfig->cacheDirectory('./.cache/rector');

        $ciDetectorClasses = array_filter(
            get_declared_classes(),
            static fn (string $class): bool => str_ends_with($class, '\OndraM\CiDetector\CiDetector'),
        );

        // @phpstan-ignore-next-line
        if ($ciDetectorClasses !== [] && (new ($ciDetectorClasses[array_key_first($ciDetectorClasses)])())->isCiDetected()) {
            // We are experiencing Rector fails only on CI in larger projects, so disabling parallelism by default.
            // You can override to enable it by using `$rectorConfig->parallel();`.
            $rectorConfig->disableParallel();
        }
    }
}
