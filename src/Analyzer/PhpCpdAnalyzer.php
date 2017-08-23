<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Analyzer;

use SebastianBergmann\PHPCPD\CodeCloneMap;
use SebastianBergmann\PHPCPD\Detector\Detector;
use SebastianBergmann\PHPCPD\Detector\Strategy\DefaultStrategy;
use TomasVotruba\ShopsysAnalysis\Contract\Analyzer\AnalyzerInterface;
use TomasVotruba\ShopsysAnalysis\Finder\PhpFilesFinder;

final class PhpCpdAnalyzer implements AnalyzerInterface
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
        $codeCloneMap = $this->analyzeDirectory($directory);

        return [
            'Duplicate code' => round($codeCloneMap->getPercentage(), 2)
        ];
    }

    private function analyzeDirectory(string $directory): CodeCloneMap
    {
        $files = $this->phpFilesFinder->findInDirectory($directory);

        $copyPasteDetector = new Detector(new DefaultStrategy);

        return $copyPasteDetector->copyPasteDetection($files);
    }
}
