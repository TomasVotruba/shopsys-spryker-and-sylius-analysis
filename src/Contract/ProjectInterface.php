<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Contract;

interface ProjectInterface
{
    public function getName(): string;

    /**
     * What to run to download project, install dependencies and clean them up before install.
     */
    public function prepare(): void;

    /**
     * @return string[]
     */
    public function getSources(): array;

    /**
     * Location where the project is installed.
     */
    public function getProjectDirectory(): string;

    public function getPhpstanConfig(): string;

    /**
     * @return string[]
     */
    public function getEasyCodingStandardConfigs(): array;
}
