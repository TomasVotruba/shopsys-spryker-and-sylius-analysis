<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Project;

use TomasVotruba\ShopsysAnalysis\Contract\ProjectInterface;

final class ShopsysProject implements ProjectInterface
{
    public function getName(): string
    {
        return 'Shopsys';
    }

    /**
     * @return string[]
     */
    public function getSources(): array
    {
        return [
            __DIR__ . '/../../project/shopsys/packages',
            __DIR__ . '/../../project/shopsys/project-base/src',
        ];
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
        return [
            __DIR__ . '/../../config/ecs/clean-code.yml',
            __DIR__ . '/../../config/ecs/psr2.yml',
        ];
    }
}
