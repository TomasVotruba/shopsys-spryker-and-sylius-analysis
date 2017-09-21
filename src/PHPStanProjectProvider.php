<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis;

final class PHPStanProjectProvider
{
    /**
     * @return string[]
     */
    public function provide(): array
    {
        return [
            'Shopsys' => 'vendor/bin/phpstan analyse project/shopsys/src project/shopsys/vendor/shopsys '
                . '--configuration phpstan-shopsys.neon --level %d',
            'Spryker' => 'vendor/bin/phpstan analyse project/spryker/vendor/spryker '
                . '--configuration phpstan-spryker.neon --level %d',
            'Sylius' => 'vendor/bin/phpstan analyse project/sylius/src '
                . '--configuration phpstan-sylius.neon --level %d',
        ];
    }
}
