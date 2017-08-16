<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Analyzer;

use SebastianBergmann\PHPCPD\CodeCloneMap;
use SebastianBergmann\PHPCPD\Detector\Detector;
use SebastianBergmann\PHPCPD\Detector\Strategy\DefaultStrategy;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\ShopsysAnalysis\Contract\Analyzer\AnalyzerInterface;
use TomasVotruba\ShopsysAnalysis\Finder\PhpFilesFinder;

final class PhpCpdAnalyzer implements AnalyzerInterface
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
        $codeCloneMap = $this->analyzeDirectory($directory);

        $this->symfonyStyle->write(sprintf(
            'Duplicate code: %0.2f %%',
            $codeCloneMap->getPercentage()
        ));
    }

    private function analyzeDirectory(string $directory): CodeCloneMap
    {
        $files = $this->phpFilesFinder->findInDirectory($directory);

        $copyPasteDetector = new Detector(new DefaultStrategy);

        return $copyPasteDetector->copyPasteDetection($files);
    }
}
