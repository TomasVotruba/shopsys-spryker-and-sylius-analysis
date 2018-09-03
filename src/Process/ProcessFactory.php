<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Process;

use Symfony\Component\Process\Process;
use TomasVotruba\ShopsysAnalysis\Contract\ProjectInterface;

final class ProcessFactory
{
    public function createPHPStanProcess(ProjectInterface $project, string $level, string $tempFile): Process
    {
        // @todo relativize paths to CWD, to make output nicer and smaller

        $commandLine = sprintf(
            'vendor/bin/phpstan analyse %s --configuration %s --level %s --errorFormat json',
            implode(' ', $project->getSources()),
            $project->getPhpstanConfig(),
            $level
        );

        return $this->createProcessWithOutputToFile($commandLine, $tempFile);
    }

    public function createECSProcess(ProjectInterface $project, string $config, string $tempFile): Process
    {
        // @todo relativize paths to CWD, to make output nicer and smaller

        $commandLine = sprintf(
            'vendor/bin/ecs check %s --config %s',
            implode(' ', $project->getSources()),
            $config
        );

        return $this->createProcessWithOutputToFile($commandLine, $tempFile);
    }

    private function createProcessWithOutputToFile(string $commandLine, string $tempFile): Process
    {
        return new Process($commandLine . ' > ' . $tempFile, null, null, null, null);
    }
}
