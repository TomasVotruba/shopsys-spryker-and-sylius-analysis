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

final class PhpstanCommand extends Command
{
    /**
     * @var int
     */
    private const FIRST_LEVEL = 0;

    /**
     * @var int
     */
    private const MAX_LEVEL = 8;

    /**
     * @var string
     */
    private const ERROR_COUNT_PATTERN = '#Found (?<errorCount>[0-9]+) errors#';

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

            for ($level = self::FIRST_LEVEL; $level <= self::MAX_LEVEL; ++$level) {
                $commandLine = $this->createCommandLine($project, $level);
                $this->processLevel($commandLine, $project->getName(), $level);
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

    private function processLevel(string $commandLine, string $name, int $level): void
    {
        $tempFile = $this->createTempFileName($name, $level);

        $process = new Process($commandLine . ' > ' . $tempFile, null, null, null, null);
        if ($this->symfonyStyle->isVerbose()) {
            $this->symfonyStyle->note('Running: ' . $process->getCommandLine());
        }

        $process->run();

        $this->symfonyStyle->writeln(
            sprintf('Level %d: %d errors', $level, $this->getErrorCountFromTempFile($tempFile))
        );
    }

    private function createTempFileName(string $name, int $level): string
    {
        return sprintf('%s/_analyze_phpstan-%s-level-%d', sys_get_temp_dir(), strtolower($name), $level);
    }

    private function createCommandLine(ProjectInterface $project, int $level): string
    {
        return sprintf(
            'vendor/bin/phpstan analyse %s --configuration %s --level %d',
            implode(' ', $project->getSources()),
            $project->getPhpstanConfig(),
            $level
        );
    }
}
