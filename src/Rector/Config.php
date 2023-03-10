<?php

declare(strict_types=1);

namespace Quartetcom\StaticAnalysisKit\Rector;

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\Config\RectorConfig;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Php81\Rector\ClassConst\FinalizePublicClassConstantRector;
use Rector\PHPUnit\Rector\Class_\AddProphecyTraitRector;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SensiolabsSetList;
use Rector\Symfony\Set\SymfonySetList;

class Config
{
    public static function use(RectorConfig $rectorConfig): void
    {
        $rectorConfig->sets([
            SetList::CODE_QUALITY,
            SetList::DEAD_CODE,
            SetList::PHP_70,
            SetList::PHP_71,
            SetList::PHP_72,
            SetList::PHP_73,
            SetList::PHP_74,
            SetList::PHP_80,
            SetList::PHP_81,
            SetList::TYPE_DECLARATION,
            DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES,
            SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES,
            SensiolabsSetList::FRAMEWORK_EXTRA_61,
        ]);

        $rectorConfig->rules([
            AddProphecyTraitRector::class,
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
            fn (string $class): bool => str_ends_with($class, '\OndraM\CiDetector\CiDetector'),
        );

        // @phpstan-ignore-next-line
        if ($ciDetectorClasses !== [] && (new ($ciDetectorClasses[array_key_first($ciDetectorClasses)])())->isCiDetected()) {
            // We are experiencing Rector fails only on CI in larger projects, so disabling parallelism by default.
            // You can override to enable it by using `$rectorConfig->parallel();`.
            $rectorConfig->disableParallel();
        }
    }
}
