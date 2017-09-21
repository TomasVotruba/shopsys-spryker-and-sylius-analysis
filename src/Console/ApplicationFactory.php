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
    private $pHPStanCommand;

    public function __construct(AnalyzeCommand $analyzeCommand, PHPStanCommand $pHPStanCommand)
    {
        $this->analyzeCommand = $analyzeCommand;
        $this->pHPStanCommand = $pHPStanCommand;
    }

    public function create(): Application
    {
        $application = new Application;
        $application->add($this->analyzeCommand);
        $application->add($this->pHPStanCommand);

        return $application;
    }
}
