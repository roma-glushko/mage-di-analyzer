<?php

declare(strict_types=1);

namespace DiAnalyzer\Di;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Finder\SplFileInfo;

/**
 *
 */
class MetadataLoader extends Command
{
    /**
     *
     *
     * @param SplFileInfo $metadataFile
     *
     * @return DiData
     */
    public function load(SplFileInfo $metadataFile): DiData
    {
        $metadataPath = $metadataFile->getRealPath();
        $areaName = $metadataFile->getFilenameWithoutExtension();
        $metadataSize = $metadataFile->getSize();

        $diMetadata = include($metadataPath);

        $diData = new DiData();

        $diData->setPath($metadataPath);
        $diData->setArea($areaName);
        $diData->setSize($metadataSize);
        $diData->setArguments($diMetadata['arguments']);
        $diData->setPreferences($diMetadata['preferences']);
        $diData->setInstanceTypes($diMetadata['instanceTypes']);

        return $diData;
    }
}