<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Console;

use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use TomasVotruba\ShopsysAnalysis\Configuration\Option;

final class Application extends SymfonyApplication
{
    protected function getDefaultInputDefinition(): InputDefinition
    {
        $inputDefinition = parent::getDefaultInputDefinition();

        // adds "--project" option
        $inputDefinition->addOption(
            new InputOption(Option::PROJECT, null, InputOption::VALUE_REQUIRED, 'Use only specific project file.')
        );

        return $inputDefinition;
    }
}
