<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Analyzer;

use SebastianBergmann\PHPLOC\Analyser;
use TomasVotruba\ShopsysAnalysis\Contract\Analyzer\AnalyzerInterface;
use TomasVotruba\ShopsysAnalysis\Finder\PhpFilesFinder;

final class PhpLocAnalyzer implements AnalyzerInterface
{
    /**
     * @var PhpFilesFinder
     */
    private $phpFilesFinder;

    public function __construct(PhpFilesFinder $phpFilesFinder)
    {
        $this->phpFilesFinder = $phpFilesFinder;
    }

    /**
     * @return mixed[]
     */
    public function process(string $directory): array
    {
        $count = $this->analyzeLocInDirectory($directory);

        return [
            'Lines of code' => number_format($count['loc'], 0, '.', ' '),
            'Cyclomatic Complexity per Class' => round($count['classCcnAvg'], 2),
            'Cyclomatic Complexity per Method' => round($count['methodCcnAvg'], 2),
            'Cyclomatic Complexity per Method' => round($count['methodCcnAvg'], 2),
            'Number of Methods/Number of Classes' => round($count['methods'] / $count['classes'] ?: 1, 2),
            'Maximum Method Length' => round($count['methodLlocMax'], 2),
            'Maximum Method Cyclomatic Complexity' => round($count['methodCcnMax'], 2),
        ];
    }

    /**
     * @return mixed[]
     */
    private function analyzeLocInDirectory(string $directory): array
    {
        $files = $this->phpFilesFinder->findInDirectory($directory);

        // have to be created fresh for every project, uses cache
        return (new Analyser)->countFiles($files, false);
    }
}
