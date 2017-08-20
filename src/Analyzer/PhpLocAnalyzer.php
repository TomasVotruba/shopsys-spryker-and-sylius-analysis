<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Analyzer;

use SebastianBergmann\PHPLOC\Analyser;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\ShopsysAnalysis\Contract\Analyzer\AnalyzerInterface;
use TomasVotruba\ShopsysAnalysis\Finder\PhpFilesFinder;

final class PhpLocAnalyzer implements AnalyzerInterface
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;

    /**
     * @var PhpFilesFinder
     */
    private $phpFilesFinder;

    public function __construct(SymfonyStyle $symfonyStyle, PhpFilesFinder $phpFilesFinder)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->phpFilesFinder = $phpFilesFinder;
    }

    public function process(string $directory): void
    {
        $count = $this->analyzeLocInDirectory($directory);

        $this->symfonyStyle->writeln(sprintf(
            'Lines of code: %d',
            $count['loc']
        ));

        $this->symfonyStyle->writeln(sprintf(
            'Cyclomatic Complexity per Class: %0.2f',
            $count['classCcnAvg']
        ));

        $this->symfonyStyle->writeln(sprintf(
            'Cyclomatic Complexity per Method: %0.2f',
            $count['methodCcnAvg']
        ));

        $this->symfonyStyle->writeln(sprintf(
            'Cyclomatic Complexity per Method: %0.2f',
            $count['methodCcnAvg']
        ));

        $this->symfonyStyle->writeln(sprintf(
            'Number of Methods/Number of Classes: %0.2f',
            $count['methods'] / $count['classes'] ?: 1
        ));

        $this->symfonyStyle->writeln(sprintf(
            'Maximum Method Length: %0.2f',
            $count['methodLlocMax']
        ));

        $this->symfonyStyle->writeln(sprintf(
            'Maximum Method Cyclomatic Complexity: %0.2f',
            $count['methodCcnMax']
        ));
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
