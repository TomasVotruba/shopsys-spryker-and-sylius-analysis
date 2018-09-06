<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Process;

use Nette\Utils\Strings;
use Symfony\Component\Process\Process;
use TomasVotruba\ShopsysAnalysis\Contract\ProjectInterface;

final class ProcessFactory
{
    public function createPHPStanProcess(ProjectInterface $project, string $level, string $tempFile): Process
    {
        $commandLine = sprintf(
            'vendor/bin/phpstan analyse %s --configuration %s --level %s --error-format json',
            implode(' ', $project->getSources()),
            $project->getPhpstanConfig(),
            $level
        );

        $commandLine = $this->relativizePaths($commandLine);

        return $this->createProcessWithOutputToFile($commandLine, $tempFile);
    }

    public function createECSProcess(ProjectInterface $project, string $config, string $tempFile): Process
    {
        $commandLine = sprintf(
            'vendor/bin/ecs check %s --config %s',
            implode(' ', $project->getSources()),
            $config
        );

        $commandLine = $this->relativizePaths($commandLine);

        return $this->createProcessWithOutputToFile($commandLine, $tempFile);
    }

    private function createProcessWithOutputToFile(string $commandLine, string $tempFile): Process
    {
        return new Process($commandLine . ' > ' . $tempFile, null, null, null, null);
    }

    /**
     * This cool trick basically removed current working directory from all paths:
     *  - /var/www/something/this-repo/bin/command   →   repo/bin/command.
     */
    private function relativizePaths(string $commandLine): string
    {
        return Strings::replace($commandLine, '#' . preg_quote(getcwd()) . '\/#');
    }
}
