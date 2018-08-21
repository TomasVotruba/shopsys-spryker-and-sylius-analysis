<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Project;

use TomasVotruba\ShopsysAnalysis\Contract\ProjectInterface;
use TomasVotruba\ShopsysAnalysis\Process\ProcessRunner;

final class SyliusProject implements ProjectInterface
{
    /**
     * @var ProcessRunner
     */
    private $processRunner;

    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    public function getName(): string
    {
        return 'Sylius';
    }

    public function getVersion(): string
    {
        return 'v1.2.4';
    }

    /**
     * Url of .git repository to be cloned.
     */
    public function getGitRepository(): string
    {
        return 'https://github.com/Sylius/Sylius.git';
    }

    /**
     * @return string[]
     */
    public function getSources(): array
    {
        return [
            realpath($this->getProjectDirectory() . '/src/Sylius/Bundle'),
            realpath($this->getProjectDirectory() . '/src/Sylius/Component'),
        ];
    }

    public function getPhpstanConfig(): string
    {
        return realpath(__DIR__ . '/../../config/phpstan/sylius.neon');
    }

    /**
     * @return string[]
     */
    public function getEasyCodingStandardConfigs(): array
    {
        return [
            realpath(__DIR__ . '/../../config/ecs/clean-code.yml'),
            realpath(__DIR__ . '/../../config/ecs/psr2.yml'),
        ];
    }

    /**
     * What to run to download project, install dependencies and clean them up before install.
     */
    public function prepare(): void
    {
        $this->processRunner->runAndReport(
            sprintf(
                'git clone %s --depth 1 --single-branch --branch %s project/sylius',
                $this->getGitRepository(),
                $this->getVersion()
            )
        );
        $this->processRunner->runAndReport('composer install --working-dir project/sylius --no-dev --no-interaction');
    }

    /**
     * Location where the project is installed.
     */
    public function getProjectDirectory(): string
    {
        return realpath(__DIR__ . '/../../project/sylius');
    }
}
