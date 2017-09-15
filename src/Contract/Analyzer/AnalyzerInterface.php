<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Contract\Analyzer;

interface AnalyzerInterface
{
    /**
     * @param string[] $directories
     * @return mixed { name => value }
     */
    public function process(array $directories): array;
}
