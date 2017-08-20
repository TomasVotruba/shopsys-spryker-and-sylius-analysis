<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symplify\PackageBuilder\Adapter\Symfony\DependencyInjection\DefinitionCollector;
use TomasVotruba\ShopsysAnalysis\Command\AnalyzeCommand;
use TomasVotruba\ShopsysAnalysis\Contract\Analyzer\AnalyzerInterface;

final class CollectorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $containerBuilder): void
    {
        $this->collectAnalyzersToAnalyzeCommand($containerBuilder);
    }

    private function collectAnalyzersToAnalyzeCommand(ContainerBuilder $containerBuilder): void
    {
        DefinitionCollector::loadCollectorWithType(
            $containerBuilder,
            AnalyzeCommand::class,
            AnalyzerInterface::class,
            'addAnalyzer'
        );
    }
}
