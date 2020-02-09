<?php

declare(strict_types=1);

namespace DiAnalyzer\Di;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Finder\Finder;

/**
 *
 */
class MetadataFinder extends Command
{
    static private $metadataFiles = [
        'global.php',
        'adminhtml.php',
        'frontend.php',
        'crontab.php',
        'webapi_rest.php',
        'webapi_soap.php',
    ];

    /**
     * Finds all metadata files related to Magento areas
     *
     * @param string $metadataDir
     *
     * @return Finder
     */
    public function find(string $metadataDir, array $areas = []): Finder
    {
        $areasToProcess = !count($areas) ? static::$metadataFiles : array_map(function ($area) {
            return $area . '.php';
        }, $areas);

        $finder = new Finder();

        $finder->in($metadataDir);
        $finder->name($areasToProcess);

        return $finder;
    }
}