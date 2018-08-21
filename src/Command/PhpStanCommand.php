<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Command;

use Nette\Utils\Strings;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use TomasVotruba\ShopsysAnalysis\Contract\ProjectInterface;
use TomasVotruba\ShopsysAnalysis\ProjectProvider;

final class PhpStanCommand extends Command
{
    /**
     * @var string
     */
    private const ERROR_COUNT_PATTERN = '#Found (?<errorCount>[0-9]+) errors#';

    /**
     * @var string[]|int[]
     * @see https://github.com/phpstan/phpstan/tree/master/conf
     */
    private $phpStanLevels = [0, 1, 2, 3, 4, 5, 6, 7, 'max'];

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
        $this->setName('phpstan');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->projectProvider->provide() as $project) {
            $this->symfonyStyle->title($project->getName());

            foreach ($this->phpStanLevels as $phpStanLevel) {
                $commandLine = $this->createCommandLine($project, (string) $phpStanLevel);
                $this->processLevel($commandLine, $project->getName(), (string) $phpStanLevel);
            }
        }

        return 0;
    }

    private function getErrorCountFromTempFile(string $tempFile): int
    {
        $tempFileContent = file_get_contents($tempFile);
        $matches = Strings::match($tempFileContent, self::ERROR_COUNT_PATTERN);

        return (int) ($matches['errorCount'] ?? 0);
    }

    private function processLevel(string $commandLine, string $name, string $level): void
    {
        $tempFile = $this->createTempFileName($name, $level);

        $process = new Process($commandLine . ' > ' . $tempFile, null, null, null, null);
        if ($this->symfonyStyle->isVerbose()) {
            $this->symfonyStyle->note('Running: ' . $process->getCommandLine());
        }

        $process->run();

        $this->symfonyStyle->writeln(
            sprintf('Level %s: %d errors', $level, $this->getErrorCountFromTempFile($tempFile))
        );
    }

    private function createTempFileName(string $name, string $level): string
    {
        return sprintf('%s/_analyze_phpstan-%s-level-%s', sys_get_temp_dir(), strtolower($name), $level);
    }

    private function createCommandLine(ProjectInterface $project, string $level): string
    {
        return sprintf(
            'vendor/bin/phpstan analyse %s --configuration %s --level %s',
            implode(' ', $project->getSources()),
            $project->getPhpstanConfig(),
            $level
        );
    }
}
