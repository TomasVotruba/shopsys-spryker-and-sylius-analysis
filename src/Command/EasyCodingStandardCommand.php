<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\PackageBuilder\Console\Command\CommandNaming;
use TomasVotruba\ShopsysAnalysis\ProjectProvider;

final class EasyCodingStandardCommand extends Command
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;

    /**
     * @var ProjectProvider
     */
    private $projectProvider;

    public function __construct(SymfonyStyle $symfonyStyle, ProjectProvider $projectProvider)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->projectProvider = $projectProvider;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(CommandNaming::classToName(self::class));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->projectProvider->provide() as $project) {
            $this->symfonyStyle->title($project->getName());

            dump($project->getEasyCodingStandardConfigs());
            die;

            $this->processLevels($cli, $name);

            $this->symfonyStyle->newLine();
        }

        $this->deleteTempFiles();

        return 0;
    }

//    private function getErrorCountFromTempFile(string $tempFile): int
//    {
//        $tempFileContent = file_get_contents($tempFile);
//        $matches = Strings::match($tempFileContent, self::ERROR_COUNT_PATTERN);
//
//        return (int) ($matches['errorCount'] ?? 0);
//    }

//    private function deleteTempFiles(): void
//    {
//        $finder = Finder::create()
//            ->files()
//            ->ignoreDotFiles(true)
//            ->in(getcwd() . '/temp');
//
//        /** @var SplFileInfo[] $files */
//        $files = iterator_to_array($finder->getIterator());
//
//        foreach ($files as $file) {
//            unlink($file->getRealPath());
//        }
//    }

//    private function processLevels(string $cli, string $name): void
//    {
//        for ($level = self::FIRST_LEVEL; $level <= self::MAX_LEVEL; ++$level) {
//            $this->processLevel($cli, $name, $level);
//        }
//    }
//
//    private function processConfig(string $cli, string $name, int $level): void
//    {
//        $finalCli = sprintf($cli, $level);
//        $tempFile = $this->createTempFileName($name, $level);
//
//        $process = new Process($finalCli . ' > ' . $tempFile, null, null, null, null);
//        $this->symfonyStyle->note('Running: ' . $process->getCommandLine());
//        $process->run();
//
//        $this->symfonyStyle->writeln(sprintf(
//            'Level %d: %d errors',
//            $level,
//            $this->getErrorCountFromTempFile($tempFile)
//        ));
//    }

//    private function createTempFileName(string $name, int $level): string
//    {
//        return 'temp/phpstan-' . strtolower($name) . '-level-' . $level;
//    }
}
