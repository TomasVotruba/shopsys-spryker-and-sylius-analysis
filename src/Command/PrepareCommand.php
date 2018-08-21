<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\PackageBuilder\Console\Command\CommandNaming;
use TomasVotruba\ShopsysAnalysis\ProjectProvider;

final class PrepareCommand extends Command
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;

    /**
     * @var ProjectProvider
     */
    private $projectProvider;

    public function __construct(SymfonyStyle $symfonyStyle, ProjectProvider $projectProvider)
    {
        parent::__construct();
        $this->symfonyStyle = $symfonyStyle;
        $this->projectProvider = $projectProvider;
    }

    protected function configure(): void
    {
        $this->setName(CommandNaming::classToName(self::class));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->projectProvider->provide() as $project) {
            $project->prepare();

            $this->symfonyStyle->success(sprintf(
                'Project "%s" is prepared in "%s" directory',
                $project->getName(),
                $project->getProjectDirectory()
            ));
        }

        // success
        return 0;
    }
}
