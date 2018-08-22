<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Project;

use Nette\Utils\FileSystem;
use Nette\Utils\Json;
use TomasVotruba\ShopsysAnalysis\Contract\ProjectInterface;
use TomasVotruba\ShopsysAnalysis\Process\ProcessRunner;

final class ShopsysProject implements ProjectInterface
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
        return 'v7.0.0-alpha5';
    }

    /**
     * Url of .git repository to be cloned.
     */
    public function getGitRepository(): string
    {
        return 'https://github.com/shopsys/shopsys.git';
    }

    public function getName(): string
    {
        return 'Shopsys';
    }

    /**
     * @return string[]
     */
    public function getSources(): array
    {
        return [$this->getProjectDirectory() . '/packages', $this->getProjectDirectory() . '/project-base/src'];
    }

    public function getPhpstanConfig(): string
    {
        return realpath(__DIR__ . '/../../config/phpstan/shopsys.neon');
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
                'git clone %s --depth 1 --single-branch --branch %s project/shopsys',
                $this->getGitRepository(),
                $this->getVersion()
            )
        );

        $this->prepareShopsysComposerJson();

        $this->processRunner->runAndReport('composer install --working-dir project/shopsys --no-dev --no-interaction');
        $this->processRunner->runAndReport('rm -rf project/shopsys/vendor/nikic project/shopsys/vendor/phpstan');
    }

    /**
     * Location where the project is installed.
     */
    public function getProjectDirectory(): string
    {
        return realpath(__DIR__ . '/../../project/shopsys');
    }

    private function prepareShopsysComposerJson(): void
    {
        // load
        $shopsysComposerJson = FileSystem::read($this->getProjectDirectory() . '/composer.json');
        $shopsysComposerData = Json::decode($shopsysComposerJson, Json::FORCE_ARRAY);

        // fix long install run on Doctrine custom branch
        $shopsysComposerData['require']['doctrine/orm'] = '^2.6';

        // @todo fix install on travis
        // - https://api.github.com/repos/molaux/PostgreSearchBundle unable to install
        // see https://github.com/TomasVotruba/shopsys-spryker-and-sylius-analysis/pull/16#issue-209768449

        // save
        $shopsysComposerJson = Json::encode($shopsysComposerData, Json::PRETTY);
        FileSystem::write($this->getProjectDirectory() . '/composer.json', $shopsysComposerJson);
    }
}
