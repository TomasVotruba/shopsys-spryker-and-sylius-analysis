<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Project;

use TomasVotruba\ShopsysAnalysis\Contract\ProjectInterface;

final class SprykerProject implements ProjectInterface
{
    public function getName(): string
    {
        return 'Spryker';
    }

    /**
     * @return string[]
     */
    public function getSources(): array
    {
        return [
            __DIR__ . '/../../project/spryker/vendor/spryker'
        ];
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
        return [
            __DIR__ . '/../../config/ecs/clean-code.yml',
            __DIR__ . '/../../config/ecs/psr2.yml',
        ];
    }
}
