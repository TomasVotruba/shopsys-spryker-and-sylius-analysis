<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Contract\Analyzer;

interface AnalyzerInterface
{
    /**
     * @return mixed { name => value }
     */
    public function process(string $directory): array;
}
