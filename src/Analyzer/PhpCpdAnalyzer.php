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
     * @param string[] $directories
     * @return mixed[]
     */
    public function process(array $directories): array
    {
        $codeCloneMap = $this->analyzeDirectories($directories);

        return [
            'Duplicate code' => round((float) $codeCloneMap->getPercentage(), 2),
        ];
    }

    /**
     * @param string[] $directories
     */
    private function analyzeDirectories(array $directories): CodeCloneMap
    {
        $files = $this->phpFilesFinder->findInDirectories($directories);

        $copyPasteDetector = new Detector(new DefaultStrategy);

        return $copyPasteDetector->copyPasteDetection($files);
    }
}
