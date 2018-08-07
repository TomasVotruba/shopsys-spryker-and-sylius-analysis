<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\DependencyInjection\CompilerPass;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symplify\PackageBuilder\DependencyInjection\DefinitionCollector;
use Symplify\PackageBuilder\DependencyInjection\DefinitionFinder;
use TomasVotruba\ShopsysAnalysis\Command\AnalyzeCommand;
use TomasVotruba\ShopsysAnalysis\Contract\Analyzer\AnalyzerInterface;

final class CollectorCompilerPass implements CompilerPassInterface
{
    /**
     * @var DefinitionCollector
     */
    private $definitionCollector;

    public function __construct()
    {
        $this->definitionCollector = (new DefinitionCollector(new DefinitionFinder()));
    }

    public function process(ContainerBuilder $containerBuilder): void
    {
        $this->collectAnalyzersToAnalyzeCommand($containerBuilder);
        $this->collectCommandsToApplication($containerBuilder);
    }

    private function collectAnalyzersToAnalyzeCommand(ContainerBuilder $containerBuilder): void
    {
        $this->definitionCollector->loadCollectorWithType(
            $containerBuilder,
            AnalyzeCommand::class,
            AnalyzerInterface::class,
            'addAnalyzer'
        );
    }

    private function collectCommandsToApplication(ContainerBuilder $containerBuilder): void
    {
        $this->definitionCollector->loadCollectorWithType(
            $containerBuilder,
            Application::class,
            Command::class,
            'add'
        );
    }
}
