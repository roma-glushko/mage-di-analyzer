<?php

declare(strict_types=1);

namespace DiAnalyzer\Analyzer;

use DiAnalyzer\Di\DiData;
use DiAnalyzer\Module\ModuleResolver;
use DiAnalyzer\Report\ModuleReport;

/**
 *
 */
class ModuleAnalyzer
{
    /**
     * @var ModuleResolver
     */
    private $moduleResolver;

    /**
     */
    public function __construct()
    {
        $this->moduleResolver = new ModuleResolver();
    }

    /**
     * Analyze how Magento modules contribute to compiled DI data
     *
     * @param DiData[] $diDataList
     *
     * @return ModuleReport
     */
    public function analyze(array $diDataList): ModuleReport
    {
        $moduleReport = new ModuleReport();

        foreach ($diDataList as $diData) {
            foreach ($this->getModuleStatistic($diData) as $moduleArgStat) {
                $moduleReport->addDataRow([
                    'module_name' => $moduleArgStat['module_name'],
                    'area' => $diData->getArea(),
                    'arguments' => $moduleArgStat['arguments'],
                    'preferences' => $moduleArgStat['preferences'],
                    'instance_types' => $moduleArgStat['instance_types'],
                ]);
            }
        }

        return $moduleReport;
    }

    /**
     * @param array $diConfig
     * @param string $statisticName
     *
     * @return array
     */
    private function getModuleStatistic(DiData $diConfig): array
    {
        $moduleStatistic = [];

        foreach ($diConfig->getArguments() as $className => $classDiConfig) {
            $moduleName = $this->moduleResolver->resolve($className);

            if (!array_key_exists($moduleName, $moduleStatistic)) {
                $moduleStatistic[$moduleName] = [
                    'module_name' => $moduleName,
                    'arguments' => 0,
                    'preferences' => 0,
                    'instance_types' => 0,
                ];
            }

            $moduleStatistic[$moduleName]['arguments']++;
        }

        foreach ($diConfig->getPreferences() as $className => $classDiConfig) {
            $moduleName = $this->moduleResolver->resolve($className);

            if (!array_key_exists($moduleName, $moduleStatistic)) {
                $moduleStatistic[$moduleName] = [
                    'module_name' => $moduleName,
                    'arguments' => 0,
                    'preferences' => 0,
                    'instance_types' => 0,
                ];
            }

            $moduleStatistic[$moduleName]['preferences']++;
        }

        foreach ($diConfig->getInstanceTypes() as $className => $classDiConfig) {
            $moduleName = $this->moduleResolver->resolve($className);

            if (!array_key_exists($moduleName, $moduleStatistic)) {
                $moduleStatistic[$moduleName] = [
                    'module_name' => $moduleName,
                    'arguments' => 0,
                    'preferences' => 0,
                    'instance_types' => 0,
                ];
            }

            $moduleStatistic[$moduleName]['instance_types']++;
        }

        return $moduleStatistic;
    }
}