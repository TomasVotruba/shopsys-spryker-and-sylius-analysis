<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis;

use Iterator;

final class PHPStanProjectProvider
{
    /**
     * @return string[]
     */
    public function provide(): Iterator
    {
        yield [
            'Shopsys' => 'vendor/bin/phpstan analyse project/shopsys/packages project/shopsys/project-base/src --configuration phpstan-shopsys.neon --level %d'
        ];

        yield [
            'Spryker' => 'vendor/bin/phpstan analyse project/spryker/vendor/spryker --configuration phpstan-spryker.neon --level %d'
        ];

        yield [
            'Sylius' => 'vendor/bin/phpstan analyse project/sylius/src/Sylius/Bundle project/sylius/src/Sylius/Component --configuration phpstan-sylius.neon --level %d'
        ];
    }
}
