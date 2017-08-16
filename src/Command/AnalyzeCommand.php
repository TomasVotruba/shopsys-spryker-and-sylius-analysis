<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Command;

use SebastianBergmann\PHPLOC\Analyser;
use SplFileInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use TomasVotruba\ShopsysAnalysis\Finder\PhpFilesFinder;
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
     * @var PhpFilesFinder
     */
    private $phpFilesFinder;

    public function __construct(
        SymfonyStyle $symfonyStyle,
        ProjectProvider $projectProvider,
        PhpFilesFinder $phpFilesFinder
    ) {
        $this->symfonyStyle = $symfonyStyle;
        $this->projectProvider = $projectProvider;
        $this->phpFilesFinder = $phpFilesFinder;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('analyze');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->projectProvider->provide() as $name => $source) {
            $count = $this->analyzeLocInDirectory($source);

            $this->symfonyStyle->title($name);

            $this->symfonyStyle->writeln(sprintf(
                'Lines of code (LOC): %d',
                $count['loc']
            ));

            $this->symfonyStyle->writeln(sprintf(
                'Cyclomatic Complexity per Class: %0.2f',
                $count['classCcnAvg']
            ));

            $this->symfonyStyle->writeln(sprintf(
                'Cyclomatic Complexity per Method: %0.2f',
                $count['methodCcnAvg']
            ));

            $this->symfonyStyle->writeln(sprintf(
                'Cyclomatic Complexity per Method: %0.2f',
                $count['methodCcnAvg']
            ));

            $this->symfonyStyle->writeln(sprintf(
                'Number of Methods/Number of Classes: %0.2f',
                $count['methods'] / $count['classes'] ?: 1
            ));

            $this->symfonyStyle->newLine(2);
        }

        return 1;
    }

    /**
     * @return mixed[]
     */
    private function analyzeLocInDirectory(string $directory): array
    {
        $files = $this->phpFilesFinder->findInDirectory($directory);

        // have to be created fresh for every project, uses cache
        return (new Analyser)->countFiles($files, false);
    }
}
