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

    public function getName(): string
    {
        return 'Shopsys';
    }

    /**
     * @return string[]
     */
    public function getSources(): array
    {
        return [__DIR__ . '/../../project/shopsys/packages', __DIR__ . '/../../project/shopsys/project-base/src'];
    }

    public function getPhpstanConfig(): string
    {
        return __DIR__ . '/../../config/phpstan/shopsys.neon';
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
            'git clone https://github.com/shopsys/shopsys.git --depth 1 --single-branch --branch v7.0.0-alpha4 project/shopsys'
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
        return __DIR__ . '/../../project/shopsys';
    }

    private function prepareShopsysComposerJson(): void
    {
        // load
        $shopsysComposerJson = FileSystem::read($this->getShopsysComposerJsonFilePath());
        $shopsysComposerData = Json::decode($shopsysComposerJson, Json::FORCE_ARRAY);

        // fix long install run on Doctrine custom branch
        $shopsysComposerData['require']['doctrine/orm'] = '^2.6';

        // @todo fix install on travis
        // - https://api.github.com/repos/molaux/PostgreSearchBundle unable to install

        // save
        $shopsysComposerJson = Json::encode($shopsysComposerData, Json::PRETTY);
        FileSystem::write($this->getShopsysComposerJsonFilePath(), $shopsysComposerJson);
    }

    private function getShopsysComposerJsonFilePath(): string
    {
        return __DIR__ . '/../../project/shopsys/composer.json';
    }
}
