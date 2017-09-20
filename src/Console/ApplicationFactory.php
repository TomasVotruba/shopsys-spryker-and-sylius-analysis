<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Console;

use Symfony\Component\Console\Application;
use TomasVotruba\ShopsysAnalysis\Command\AnalyzeCommand;
use TomasVotruba\ShopsysAnalysis\Command\PHPStanCommand;

final class ApplicationFactory
{
    /**
     * @var AnalyzeCommand
     */
    private $analyzeCommand;

    /**
     * @var PHPStanCommand
     */
    private $phpStanCommand;

    public function __construct(AnalyzeCommand $analyzeCommand, PHPStanCommand $phpStanCommand)
    {
        $this->analyzeCommand = $analyzeCommand;
        $this->phpStanCommand = $phpStanCommand;
    }

    public function create(): Application
    {
        $application = new Application;
        $application->add($this->analyzeCommand);
        $application->add($this->phpStanCommand);

        return $application;
    }
}
