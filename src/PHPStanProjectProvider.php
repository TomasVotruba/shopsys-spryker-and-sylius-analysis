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
        yield 'Shopsys' => $this->createCommandLine([
            __DIR__ . '/../project/shopsys/packages',
            __DIR__ . '/../project/shopsys/project-base/src',
        ],
            __DIR__ . '/../config/phpstan/shopsys.neon'
        );

        yield 'Spryker' => $this->createCommandLine([__DIR__ . '/../project/spryker/vendor/spryker'],
            __DIR__ . '/../config/phpstan/spryker.neon'
        );

        yield 'Sylius' => $this->createCommandLine([
            __DIR__ . '/../project/sylius/src/Sylius/Bundle',
            __DIR__ . '/../project/sylius/src/Sylius/Component',
        ],
            __DIR__ . '/../config/phpstan/sylius.neon'
        );
    }

    /**
     * @param string[] $source
     */
    private function createCommandLine(array $source, string $config): string
    {
        return sprintf(
            'vendor/bin/phpstan analyse %s --configuration %s --level %%d',
            implode(' ', $source),
            $config
        );
    }
}
