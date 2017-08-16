<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Contract\Analyzer;

interface AnalyzerInterface
{
    public function process(string $directory): void;
}
