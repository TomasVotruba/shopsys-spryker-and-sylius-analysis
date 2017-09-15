<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Finder;

use SplFileInfo;
use Symfony\Component\Finder\Finder;

final class PhpFilesFinder
{
    /**
     * @var SplFileInfo[][]
     */
    private $cachedDirectoryResults = [];

    /**
     * @param string[] $directories
     * @return SplFileInfo[]
     */
    public function findInDirectories(array $directories): array
    {
        $cacheKey = md5(serialize($directories));
        if (isset($this->cachedDirectoryResults[$cacheKey])) {
            return $this->cachedDirectoryResults[$cacheKey];
        }

        /** @var Finder $finder */
        $finder = Finder::create()->in($directories)
            ->ignoreUnreadableDirs()
            ->exclude('spec')
            ->exclude('test')
            ->exclude('Tests')
            ->exclude('tests')
            ->exclude('Behat')
            ->name('*.php');

        $files = [];
        foreach ($finder as $file) {
            $files[] = $file->getRealpath();
        }

        $this->cachedDirectoryResults[$cacheKey] = $files;

        return $files;
    }
}
