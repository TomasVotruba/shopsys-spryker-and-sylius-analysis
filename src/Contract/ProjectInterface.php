<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Contract;

interface ProjectInterface
{
    public function getName(): string;

    /**
     * Version of project to be checked.
     */
    public function getVersion(): string;

    /**
     * Url of .git repository to be cloned.
     */
    public function getGitRepository(): string;

    /**
     * What to run to download project, install dependencies and clean them up before install.
     */
    public function prepare(): void;

    /**
     * What directories should be analysed. The source code of framework/platform.
     * @return string[]
     */
    public function getSources(): array;

    /**
     * Location where the project is installed.
     */
    public function getProjectDirectory(): string;

    /**
     * Config that will be used for PHPStan - including autoloading and ignores.
     */
    public function getPhpstanConfig(): string;

    /**
     * Configs that will be used for EasyCodingStandard - including autoloading and ignores.
     *
     * @return string[]
     */
    public function getEasyCodingStandardConfigs(): array;
}
