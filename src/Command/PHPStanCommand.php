<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Command;

use Nette\Utils\Strings;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use TomasVotruba\ShopsysAnalysis\Contract\Analyzer\AnalyzerInterface;
use TomasVotruba\ShopsysAnalysis\PHPStanProjectProvider;
use TomasVotruba\ShopsysAnalysis\ProjectProvider;

final class PHPStanCommand extends Command
{
    /**
     * @var int
     */
    private const FIRST_LEVEL = 0;

    /**
     * @var int
     */
    private const LEVEL_COUNT = 7;

    /**
     * @var string
     */
    private const ERROR_COUNT_PATTERN = '#Found (?<errorCount>[0-9]+) errors#';

    /**
     * @var string
     */
    public const NAME = 'phpstan';

    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;

    /**
     * @var PHPStanProjectProvider
     */
    private $phpStanProjectProvider;

    public function __construct(SymfonyStyle $symfonyStyle, PHPStanProjectProvider $phpStanProjectProvider)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->phpStanProjectProvider = $phpStanProjectProvider;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(self::NAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->phpStanProjectProvider->provide() as $name => $cli) {
            $this->symfonyStyle->title($name);

            for ($level = self::FIRST_LEVEL; $level <= self::LEVEL_COUNT; $level++) {
                $finalCli = sprintf($cli, $level);
                $tempFile = $this->createTempFileName($name, $level);

                $process = new Process($finalCli . ' > ' . $tempFile, null, null, null, null);
                $process->run();

                $this->symfonyStyle->writeln(sprintf(
                    'Level %d: %d errors',
                    $level,
                    $this->getErrorCountFromTempFile($tempFile)
                ));
            }

            $this->symfonyStyle->newLine();
        }

        return 0;
    }

    private function createTempFileName(string $name, int $level): string
    {
        return 'temp/phpstan-' . strtolower($name) . '-level-' . $level;
    }

    private function getErrorCountFromTempFile(string $tempFile): int
    {
        $tempFileContent = file_get_contents($tempFile);
        $matches = Strings::match($tempFileContent, self::ERROR_COUNT_PATTERN);

        return (int) ($matches['errorCount'] ?? 0);
    }
}
