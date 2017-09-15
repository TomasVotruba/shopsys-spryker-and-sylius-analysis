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
            'Shopsys' => [
                __DIR__ . '/../project/shopsys/src',
                __DIR__ . '/../project/shopsys/vendor/shopsys',
            ],
            'Sylius' => [
                __DIR__ . '/../project/sylius/src',
            ],
            'Spryker' => [
                __DIR__ . '/../project/spryker/vendor/spryker',
            ]
        ];
    }
}
