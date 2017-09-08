<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\EasyCodingStandard\Finder;

use IteratorAggregate;
use Nette\Utils\Finder;
use Symplify\EasyCodingStandard\Contract\Finder\CustomSourceProviderInterface;

final class SourceProvider implements CustomSourceProviderInterface
{
    /**
     * @param string[] $source
     */
    public function find(array $source): IteratorAggregate
    {
        return Finder::findFiles(['*.php'])
            ->from($source)
            ->exclude('vendor')
            ->exclude('test')
            ->exclude('Tests')
            ->exclude('tests')
            ->exclude('spec')
            ->exclude('Behat');
    }
}
