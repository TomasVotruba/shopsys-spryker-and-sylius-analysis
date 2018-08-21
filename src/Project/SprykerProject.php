<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Project;

use TomasVotruba\ShopsysAnalysis\Contract\ProjectInterface;
use TomasVotruba\ShopsysAnalysis\Process\ProcessRunner;

final class SprykerProject implements ProjectInterface
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
        return 'Spryker';
    }

    /**
     * @return string[]
     */
    public function getSources(): array
    {
        // can be a glob for Symfony\Finder
        return [$this->getProjectDirectory() . '/vendor/spryker/*/src'];
    }

    public function getPhpstanConfig(): string
    {
        return __DIR__ . '/../../config/phpstan/spryker.neon';
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
            'git clone https://github.com/spryker/demoshop --depth 1 --single-branch --branch 2.32 project/spryker'
        );
        $this->processRunner->runAndReport('composer install --working-dir project/spryker --no-dev --no-interaction');
    }

    /**
     * Location where the project is installed.
     */
    public function getProjectDirectory(): string
    {
        return __DIR__ . '/../../project/spryker';
    }
}
