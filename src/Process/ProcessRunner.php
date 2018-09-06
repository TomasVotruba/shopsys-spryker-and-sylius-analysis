<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Process;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

final class ProcessRunner
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;

    public function __construct(SymfonyStyle $symfonyStyle)
    {
        $this->symfonyStyle = $symfonyStyle;
    }

    /**
     * @param mixed[]|null $envVariables
     */
    public function runAndReport(string $commandLine, ?string $workingDir = null, ?array $envVariables = null): void
    {
        $process = new Process($commandLine, $workingDir, $envVariables, null, 200.0);
        $this->symfonyStyle->note('Running: ' . $process->getCommandLine());

        $process->run();

        // report output
        if ($process->getOutput()) {
            $this->symfonyStyle->note($process->getOutput());
        } elseif ($process->getErrorOutput()) {
            $this->symfonyStyle->error($process->getErrorOutput());
        }
    }
}
