<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\ShopsysAnalysis\Analyzer\PhpLocAnalyzer;
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
     * @var PhpLocAnalyzer
     */
    private $phpLocAnalyzer;

    public function __construct(
        SymfonyStyle $symfonyStyle,
        ProjectProvider $projectProvider,
        PhpLocAnalyzer $phpLocAnalyzer
    ) {
        $this->symfonyStyle = $symfonyStyle;
        $this->projectProvider = $projectProvider;
        $this->phpLocAnalyzer = $phpLocAnalyzer;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('analyze');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->projectProvider->provide() as $name => $source) {
            // skip non-existing source, e.g. on Travis
            if (! file_exists($source)) {
                continue;
            }

            $this->phpLocAnalyzer->process($name, $source);

            $this->symfonyStyle->newLine(2);
        }

        return 1;
    }
}
