<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\PHPStan;

use Nette\Loaders\RobotLoader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class TestsExcludingRobotLoader
{
    public function loadDirectoryWithoutTests(string $directory): void
    {
        $robotLoader = $this->createRobotLoader();

        $robotLoader->addDirectory($directory);

        $directoriesWithTests = $this->getDirectoriesWithTests($directory);
        foreach ($directoriesWithTests as $directoryWithTests) {
            $robotLoader->excludeDirectory($directoryWithTests->getRealPath());
        }

        $robotLoader->register();
    }

    /**
     * @return SplFileInfo[]
     */
    private function getDirectoriesWithTests(string $directory): array
    {
        $finder = Finder::create()->directories()
            ->in($directory)
            ->name('Tests')
            ->name('tests')
            ->name('test');

        return iterator_to_array($finder->getIterator());
    }

    private function createRobotLoader(): RobotLoader
    {
        $robotLoader = new RobotLoader;
        $robotLoader->acceptFiles = '*.php';
        $robotLoader->setTempDirectory(sys_get_temp_dir() . '/_static-anal-robot-loader');

        return $robotLoader;
    }
}
