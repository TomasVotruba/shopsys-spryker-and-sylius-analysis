<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Project;

use TomasVotruba\ShopsysAnalysis\Contract\ProjectInterface;

final class SyliusProject implements ProjectInterface
{
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
}
