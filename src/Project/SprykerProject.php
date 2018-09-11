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

    /**
     * Version of project to be checked.
     */
    public function getVersion(): string
    {
        return '2.32';
    }

    /**
     * Url of .git repository to be cloned.
     */
    public function getGitRepository(): string
    {
        return 'https://github.com/spryker/demoshop';
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
        return realpath(__DIR__ . '/../../config/phpstan/spryker.neon');
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
                'git clone %s --depth 1 --single-branch --branch %s project/spryker',
                $this->getGitRepository(),
                $this->getVersion()
            )
        );
        $this->processRunner->runAndReport('composer install --working-dir project/spryker --no-interaction');

        // remove phpstan, it has another version than root one → conflicts
        $this->processRunner->runAndReport('composer remove phpstan/phpstan');

        // added on Mark's advice - https://github.com/spryker/demoshop/blob/5d8ed7405f754d9aefdad2c412a6eab1866e18c7/.travis.yml#L98-L104
        $commandsToRun = [
            'vendor/bin/console transfer:generate',
            'vendor/bin/console propel:schema:copy',
            'vendor/bin/console propel:model:build',
            'vendor/bin/console transfer:generate',
            'vendor/bin/console dev:ide:generate-auto-completion',
            'vendor/bin/codecept build --ansi',
            'vendor/bin/console transfer:databuilder:generate',
        ];

        foreach ($commandsToRun as $commandToRun) {
            $this->processRunner->runAndReport($commandToRun, 'project/spryker', [
                'APPLICATION_ENV' => 'development',
            ]);
        }
    }

    /**
     * Location where the project is installed.
     */
    public function getProjectDirectory(): string
    {
        return realpath(__DIR__ . '/../../project/spryker');
    }
}
