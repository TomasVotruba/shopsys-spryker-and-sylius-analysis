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

    /**
     * @return string[]
     */
    public function getSources(): array
    {
        return [
            __DIR__ . '/../../project/sylius/src/Sylius/Bundle',
            __DIR__ . '/../../project/sylius/src/Sylius/Component',
        ];
    }

    public function getPhpstanConfig(): string
    {
        return __DIR__ . '/../../config/phpstan/sylius.neon';
    }

    /**
     * @return string[]
     */
    public function getEasyCodingStandardConfigs(): array
    {
        return [__DIR__ . '/../../config/ecs/clean-code.yml', __DIR__ . '/../../config/ecs/psr2.yml'];
    }

    /**
     * What to run to download project, install dependencies and clean them up before install.
     */
    public function prepare(): void
    {
        $this->processRunner->runAndReport(
            'git clone https://github.com/Sylius/Sylius.git --depth 1 --single-branch --branch v1.2.4 project/sylius'
        );
        $this->processRunner->runAndReport('composer install --working-dir project/sylius --no-dev --no-interaction');
    }

    /**
     * Location where the project is installed.
     */
    public function getProjectDirectory(): string
    {
        return __DIR__ . '/../../project/sylius';
    }
}
