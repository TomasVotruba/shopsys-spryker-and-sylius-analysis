<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Finder;

use SplFileInfo;
use Symfony\Component\Finder\Finder;

final class PhpFilesFinder
{
    /**
     * @return SplFileInfo[]
     */
    public function findInDirectory(string $directory): array
    {
        $finder = Finder::create()->in($directory)
            ->ignoreUnreadableDirs()
            ->exclude('spec')
            ->exclude('test')
            ->exclude('Tests')
            ->exclude('tests')
            ->exclude('Behat')
            ->name('*.php')
            ->getIterator();

        return iterator_to_array($finder);
    }
}
