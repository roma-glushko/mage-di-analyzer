<?php

declare(strict_types=1);

namespace DiAnalyzer\Report;

/**
 *
 */
class ModuleReport implements ReportInterface
{
    static private $reportHeader = [
        'Module Name' => 'module_name',
        'Area' => 'area',
        'Arguments' => 'arguments',
        'Preferences' => 'preferences',
        'Instance Types' => 'instance_types',
    ];

    /**
     * @var array
     */
    private $reportData = [];

    /**
     * @param array $rowData
     */
    public function addDataRow(array $rowData): void
    {
        $this->reportData[] = $rowData;
    }

    public function getHeader(): array
    {
        return array_keys(static::$reportHeader);
    }

    /**
     * @return array|\Generator
     */
    public function getData(): \Generator
    {
        foreach ($this->reportData as $reportData) {
            yield [
                $reportData['module_name'],
                $reportData['area'],
                $reportData['arguments'],
                $reportData['preferences'],
                $reportData['instance_types'],
            ];
        }
    }
}