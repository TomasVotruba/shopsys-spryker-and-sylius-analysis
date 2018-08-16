<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Command;

use Nette\Utils\Strings;
use SplFileInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use TomasVotruba\ShopsysAnalysis\Contract\ProjectInterface;
use TomasVotruba\ShopsysAnalysis\ProjectProvider;

final class EcsCommand extends Command
{
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
        $this->setName('ecs');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->projectProvider->provide() as $project) {
            $this->symfonyStyle->title('ECS Analysis of ' . $project->getName());

            foreach ($project->getEasyCodingStandardConfigs() as $config) {
                $commandLine = $this->createCommandLine($project, $config);

                $name = $this->getConfigBaseName($config);
                $tempFile = $this->createTempFileName($project->getName(), $name);

                $process = new Process($commandLine . ' > ' . $tempFile, null, null, null, null);

                if ($this->symfonyStyle->isVerbose()) {
                    $this->symfonyStyle->note('Running: ' . $commandLine);
                }

                $process->run();

                $this->symfonyStyle->writeln(sprintf(
                    'Config %s: %d errors',
                    $name,
                    $this->getErrorCountFromTempFile($tempFile)
                ));
            }
        }

        return 0;
    }

    private function createCommandLine(ProjectInterface $project, string $config): string
    {
        return sprintf('vendor/bin/ecs check %s --config %s', implode(' ', $project->getSources()), $config);
    }

    private function createTempFileName(string $name, string $configName): string
    {
        return sprintf('%s/_analyze_ecs-%s-config-%s', sys_get_temp_dir(), strtolower($name), $configName);
    }

    private function getErrorCountFromTempFile(string $tempFile): int
    {
        $tempFileContent = file_get_contents($tempFile);
        $matches = Strings::match($tempFileContent, self::ERROR_COUNT_PATTERN);

        return (int) ($matches['errorCount'] ?? 0);
    }

    private function getConfigBaseName(string $config): string
    {
        return (new SplFileInfo($config))->getBasename('.yml');
    }
}
