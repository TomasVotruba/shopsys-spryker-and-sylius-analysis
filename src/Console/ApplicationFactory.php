<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Console;

use Symfony\Component\Console\Application;
use TomasVotruba\ShopsysAnalysis\Command\AnalyzeCommand;

final class ApplicationFactory
{
    /**
     * @var AnalyzeCommand
     */
    private $analyzeCommand;

    public function __construct(AnalyzeCommand $analyzeCommand)
    {
        $this->analyzeCommand = $analyzeCommand;
    }

    public function create(): Application
    {
        $application = new Application;
        $application->add($this->analyzeCommand);
        $application->setDefaultCommand(AnalyzeCommand::NAME, true);

        return $application;
    }
}
