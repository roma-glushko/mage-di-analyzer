<?php

declare(strict_types=1);

namespace DiAnalyzer\Writer;

use DiAnalyzer\Report\ReportInterface;

/**
 *
 */
class CsvWriter
{
    public function save(string $reportPath, ReportInterface $report): void
    {
        $reportFile = fopen($reportPath, 'wb');

        try {
            fputcsv($reportFile, $report->getHeader());

            foreach ($report->getData() as $dataRow) {
                fputcsv($reportFile, $dataRow);
            }
        } finally {
            fclose($reportFile);
        }
    }
}