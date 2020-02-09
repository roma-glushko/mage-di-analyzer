<?php

declare(strict_types=1);

namespace DiAnalyzer\Report;

/**
 *
 */
interface ReportInterface
{
    public function getHeader(): array;

    public function getData(): \Generator;
}