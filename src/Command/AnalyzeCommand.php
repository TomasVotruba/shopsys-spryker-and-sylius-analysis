<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TomasVotruba\ShopsysAnalysis\Analyzer\PhpCpdAnalyzer;
use TomasVotruba\ShopsysAnalysis\Analyzer\PhpLocAnalyzer;
use TomasVotruba\ShopsysAnalysis\ProjectProvider;

final class AnalyzeCommand extends Command
{
    /**
     * @var string
     */
    public const NAME = 'analyze';

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
    /**
     * @var PhpCpdAnalyzer
     */
    private $phpCpdAnalyzer;

    public function __construct(
        SymfonyStyle $symfonyStyle,
        ProjectProvider $projectProvider,
        PhpLocAnalyzer $phpLocAnalyzer,
        PhpCpdAnalyzer $phpCpdAnalyzer
    ) {
        $this->symfonyStyle = $symfonyStyle;
        $this->projectProvider = $projectProvider;
        $this->phpLocAnalyzer = $phpLocAnalyzer;
        $this->phpCpdAnalyzer = $phpCpdAnalyzer;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::NAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->projectProvider->provide() as $name => $source) {
            // skip non-existing source, e.g. on Travis
            if (! file_exists($source)) {
                continue;
            }

            $this->symfonyStyle->title($name);

            $this->phpLocAnalyzer->process($source);
            $this->phpCpdAnalyzer->process($source);

            $this->symfonyStyle->newLine(2);
        }

        return 1;
    }
}
