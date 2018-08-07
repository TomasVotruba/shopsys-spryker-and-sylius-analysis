<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\PackageBuilder\Console\Command\CommandNaming;
use TomasVotruba\ShopsysAnalysis\Contract\Analyzer\AnalyzerInterface;
use TomasVotruba\ShopsysAnalysis\ProjectProvider;

final class AnalyzeCommand extends Command
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;

    /**
     * @var ProjectProvider
     */
    private $projectProvider;

    /**
     * @var AnalyzerInterface[]
     */
    private $analyzers = [];

    public function __construct(SymfonyStyle $symfonyStyle, ProjectProvider $projectProvider)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->projectProvider = $projectProvider;
        parent::__construct();
    }

    public function addAnalyzer(AnalyzerInterface $analyzer): void
    {
        $this->analyzers[] = $analyzer;
    }

    protected function configure(): void
    {
        $this->setName(CommandNaming::classToName(self::class));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->projectProvider->provide() as $project) {
            $this->symfonyStyle->title($project->getName());

            foreach ($this->analyzers as $analyzer) {
                $data = $analyzer->process($project->getSources());
                foreach ($data as $metricName => $metricValue) {
                    $this->symfonyStyle->writeln(sprintf('%s: <options=bold>%s</>', $metricName, $metricValue));
                }
            }

            $this->symfonyStyle->newLine();
        }

        return 0;
    }
}
