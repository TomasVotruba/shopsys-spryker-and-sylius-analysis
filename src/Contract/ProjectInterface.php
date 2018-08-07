<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Contract;

interface ProjectInterface
{
    public function getName(): string;

    /**
     * @return string[]
     */
    public function getSources(): array;

    public function getPhpstanConfig(): string;

    /**
     * @return string[]
     */
    public function getEasyCodingStandardConfigs(): array;
}
