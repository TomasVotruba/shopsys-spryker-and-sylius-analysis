<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis;

final class ProjectProvider
{
    /**
     * @return string[][]
     */
    public function provide(): array
    {
        return [
            // keep alphabetical order!
            'Shopsys' => [__DIR__ . '/../project/shopsys/packages', __DIR__ . '/../project/shopsys/project-base/src'],
            'Spryker' => [__DIR__ . '/../project/spryker/vendor/spryker'],
            'Sylius' => [__DIR__ . '/../project/sylius/src'],
        ];
    }
}
