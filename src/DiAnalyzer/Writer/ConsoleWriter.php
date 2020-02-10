<?php

declare(strict_types=1);

namespace DiAnalyzer\Writer;

use DiAnalyzer\Report\ReportInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
 */
class ConsoleWriter
{
    /**
     * @param OutputInterface $output
     * @param ReportInterface $report
     */
    public function save(OutputInterface $output, ReportInterface $report): void
    {
        $table = new Table($output);
        $table->setHeaders($report->getHeader());

        foreach ($report->getData() as $dataRow) {
            $table->addRow($dataRow);
        }

        $table->render();
    }
}