<?php

declare(strict_types=1);

namespace DiAnalyzer\Module;

/**
 *
 */
class ModuleResolver
{
    static private $moduleMatchMap = [
        'Klarna_Kp' => 'Kp',
        'Magento_Elasticsearch' => 'elasticsearch',
        'Magento_Authorizenet' => 'Authorizenet',
        'ClassyLlama_AvaTax' => 'AvaTax_',
    ];

    /**
     *
     * @param string $moduleName
     *
     * @return string
     */
    public function resolve(string $instanceType): string
    {
        $moduleName = $instanceType;

        // is this a classname?
        if (strpos($instanceType, "\\") !== false) {
            $explodedClassname = explode('\\', $instanceType);
            $moduleName = $explodedClassname[0] . '_' . $explodedClassname[1];

            return $moduleName;
        }

        // try to find to which module this instance type belongs
        foreach (static::$moduleMatchMap as $moduleName => $instancePattern) {
            if (strpos($moduleName, $instancePattern) !== false) {
                return $moduleName;
            }
        }

        return $moduleName;
    }
}