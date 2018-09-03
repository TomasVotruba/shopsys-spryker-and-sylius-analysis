<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Command;

use Nette\Utils\Json;
use Nette\Utils\Strings;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use TomasVotruba\ShopsysAnalysis\Contract\ProjectInterface;
use TomasVotruba\ShopsysAnalysis\ProjectProvider;
use TomasVotruba\ShopsysAnalysis\Report\PhpStanReportSummary;

final class PhpStanCommand extends Command
{
    /**
     * @var string
     */
    private const OPTION_LEVEL = 'level';

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
    /**
     * @var PhpStanReportSummary
     */
    private $phpStanReportSummary;

    public function __construct(SymfonyStyle $symfonyStyle, ProjectProvider $projectProvider, PhpStanReportSummary $phpStanReportSummary)
    {
        parent::__construct();
        $this->symfonyStyle = $symfonyStyle;
        $this->projectProvider = $projectProvider;
        $this->phpStanReportSummary = $phpStanReportSummary;
    }

    protected function configure(): void
    {
        $this->setName('phpstan');
        $this->addOption(self::OPTION_LEVEL, null, InputOption::VALUE_REQUIRED, 'Run at specific of level');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // use custom files
        if ($input->getOption(self::OPTION_LEVEL) !== null)  {
            $this->phpStanLevels = [$input->getOption(self::OPTION_LEVEL)];
        }

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
        $resultJson = Json::decode(file_get_contents($tempFile), Json::FORCE_ARRAY);

        return (int) $resultJson['totals']['file_errors'];
    }

    private function processLevel(string $commandLine, string $name, string $level): void
    {
        $tempFile = $this->createTempFileName($name, $level);

        // the file doesn't exist or is empty → run analysis
        // @note invalidate cache form time to time
        if (! file_exists($tempFile) || ! file_get_contents($tempFile) || file_get_contents($tempFile) === '') {
            $process = new Process($commandLine . ' > ' . $tempFile, null, null, null, null);
            if ($this->symfonyStyle->isVerbose()) {
                $this->symfonyStyle->note('Running: ' . $process->getCommandLine());
            }

            $process->run();
        } else {
            $this->symfonyStyle->note(sprintf('Using cached result file "%s". Remove it to re-run.', $tempFile));
        }

        $this->symfonyStyle->writeln(
            sprintf('PHPStan Level %s: %d errors', $level, $this->getErrorCountFromTempFile($tempFile))
        );

        $this->phpStanReportSummary->processOutput(file_get_contents($tempFile));
        // @todo summary report
    }

    private function createTempFileName(string $name, string $level): string
    {
        return sprintf('%s/_analyze_phpstan-%s-level-%s', sys_get_temp_dir(), strtolower($name), $level);
    }

    private function createCommandLine(ProjectInterface $project, string $level): string
    {
        return sprintf(
            'vendor/bin/phpstan analyse %s --configuration %s --level %s --errorFormat json',
            implode(' ', $project->getSources()),
            $project->getPhpstanConfig(),
            $level
        );
    }
}
