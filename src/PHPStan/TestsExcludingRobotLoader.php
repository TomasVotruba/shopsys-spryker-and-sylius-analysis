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

        $this->excludeTestsDirectory($directory, $robotLoader);

        $robotLoader->register();
    }

    private function createRobotLoader(): RobotLoader
    {
        $robotLoader = new RobotLoader;
        $robotLoader->acceptFiles = ['*.php'];
        $robotLoader->setTempDirectory(sys_get_temp_dir() . '/_static-anal-robot-loader');

        return $robotLoader;
    }

    private function excludeTestsDirectory(string $directory, RobotLoader $robotLoader): void
    {
        $directoriesWithTests = $this->findTestDirectoriesInDirectory($directory);

        foreach ($directoriesWithTests as $directoryWithTests) {
            $robotLoader->excludeDirectory($directoryWithTests->getRealPath());
        }
    }

    /**
     * @return SplFileInfo[]
     */
    private function findTestDirectoriesInDirectory(string $directory): array
    {
        $finder = Finder::create()->directories()
            ->in($directory)
            ->name('Tests')
            ->name('tests')
            ->name('test');

        return iterator_to_array($finder->getIterator());
    }
}
