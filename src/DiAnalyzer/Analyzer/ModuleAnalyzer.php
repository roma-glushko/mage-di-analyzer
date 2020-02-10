<?php

declare(strict_types=1);

namespace DiAnalyzer\Analyzer;

use DiAnalyzer\Di\DiData;
use DiAnalyzer\Estimator\SizeEstimator;
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
     * @var SizeEstimator
     */
    private $sizeEstimator;

    /**
     */
    public function __construct()
    {
        $this->moduleResolver = new ModuleResolver();
        $this->sizeEstimator = new SizeEstimator();
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
                    'argument_size' => $moduleArgStat['argument_size'],
                    'preferences' => $moduleArgStat['preferences'],
                    'preference_size' => $moduleArgStat['preference_size'],
                    'instance_types' => $moduleArgStat['instance_types'],
                    'instance_type_size' => $moduleArgStat['instance_type_size'],
                ]);
            }
        }

        return $moduleReport;
    }

    /**
     * @param array $diConfig
     *
     * @return array
     */
    private function getModuleStatistic(DiData $diConfig): array
    {
        $moduleStatistic = [];

        foreach ($diConfig->getArguments() as $className => $argumentConfig) {
            $moduleName = $this->moduleResolver->resolve($className);

            if (!array_key_exists($moduleName, $moduleStatistic)) {
                $moduleStatistic[$moduleName] = [
                    'module_name' => $moduleName,
                    'arguments' => 0,
                    'argument_size' => 0,
                    'preferences' => 0,
                    'preference_size' => 0,
                    'instance_types' => 0,
                    'instance_type_size' => 0,
                ];
            }

            $moduleStatistic[$moduleName]['arguments']++;
            $moduleStatistic[$moduleName]['argument_size'] += $this->sizeEstimator->estimate(
                $className,
                $argumentConfig
            );
        }

        foreach ($diConfig->getPreferences() as $className => $preferenceName) {
            $moduleName = $this->moduleResolver->resolve($className);

            if (!array_key_exists($moduleName, $moduleStatistic)) {
                $moduleStatistic[$moduleName] = [
                    'module_name' => $moduleName,
                    'arguments' => 0,
                    'argument_size' => 0,
                    'preferences' => 0,
                    'preference_size' => 0,
                    'instance_types' => 0,
                    'instance_type_size' => 0,
                ];
            }

            $moduleStatistic[$moduleName]['preferences']++;
            $moduleStatistic[$moduleName]['preference_size'] += $this->sizeEstimator->estimate(
                $className,
                $preferenceName
            );
        }

        foreach ($diConfig->getInstanceTypes() as $className => $instanceType) {
            $moduleName = $this->moduleResolver->resolve($className);
            if ($className === $moduleName) {
                echo $className . ' -> ' . $moduleName . PHP_EOL;
            }

            if (!array_key_exists($moduleName, $moduleStatistic)) {
                $moduleStatistic[$moduleName] = [
                    'module_name' => $moduleName,
                    'arguments' => 0,
                    'argument_size' => 0,
                    'preferences' => 0,
                    'preference_size' => 0,
                    'instance_types' => 0,
                    'instance_type_size' => 0,
                ];
            }

            $moduleStatistic[$moduleName]['instance_types']++;
            $moduleStatistic[$moduleName]['instance_type_size'] += $this->sizeEstimator->estimate(
                $className,
                $instanceType
            );
        }

        return $moduleStatistic;
    }
}