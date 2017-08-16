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
     * @return SplFileInfo[]
     */
    public function findInDirectory(string $directory): array
    {
        if (isset($this->cachedDirectoryResults[$directory])) {
            return $this->cachedDirectoryResults[$directory];
        }

        /** @var Finder $finder */
        $finder = Finder::create()->in($directory)
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

        $this->cachedDirectoryResults[$directory] = $files;

        return $files;
    }
}
