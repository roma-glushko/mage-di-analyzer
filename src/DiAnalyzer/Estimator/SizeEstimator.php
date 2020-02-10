<?php

declare(strict_types=1);

namespace DiAnalyzer\Estimator;

/**
 *
 */
class SizeEstimator
{
    /**
     * @param string $className
     * @param array $arguments
     *
     * @return int
     */
    public function estimate(string $className, $arguments): int
    {
        $generateExpression = var_export([
            'arguments' => [$className => $arguments]
        ], true);

        return strlen($generateExpression) - 40;
    }
}