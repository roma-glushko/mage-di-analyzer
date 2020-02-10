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
        'Argument Size' => 'argument_size',
        'Preferences' => 'preferences',
        'Preference Size' => 'preference_size',
        'Instance Types' => 'instance_types',
        'Instance Type Size' => 'instance_type_size',
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
                $this->formatSize($reportData['argument_size']),
                $reportData['preferences'],
                $this->formatSize($reportData['preference_size']),
                $reportData['instance_types'],
                $this->formatSize($reportData['instance_type_size']),
            ];
        }
    }

    /**
     * @param int $sizeBytes
     * @param int $precision
     *
     * @return string
     */
    private function formatSize(int $sizeBytes, int $precision = 2): string
    {
        $units = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $step = 1024;
        $i = 0;

        while (($sizeBytes / $step) > 0.9) {
            $sizeBytes = $sizeBytes / $step;
            $i++;
        }

        return round($sizeBytes, $precision).$units[$i];
    }
}