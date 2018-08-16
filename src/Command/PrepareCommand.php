<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Command;

use Nette\Utils\FileSystem;
use Nette\Utils\Json;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\PackageBuilder\Console\Command\CommandNaming;

final class PrepareCommand extends Command
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;

    /**
     * @var string
     */
    private $projectsDirectory;

    public function __construct(string $projectsDirectory, SymfonyStyle $symfonyStyle)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->projectsDirectory = $projectsDirectory;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(CommandNaming::classToName(self::class));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // @todo fix
        // - https://api.github.com/repos/molaux/PostgreSearchBundle unable to install

        // load
        $shopsysComposerJson = FileSystem::read($this->getShopsysComposerJsonFilePath());
        $shopsysComposerData = Json::decode($shopsysComposerJson, Json::FORCE_ARRAY);

        // fix long install run on Doctrine custom branch
        $shopsysComposerData['require']['doctrine/orm'] = '^2.6';

        // save
        $shopsysComposerJson = Json::encode($shopsysComposerData, Json::PRETTY);
        FileSystem::write($this->getShopsysComposerJsonFilePath(), $shopsysComposerJson);

        // success
        return 0;
    }

    private function getShopsysComposerJsonFilePath(): string
    {
        return $this->projectsDirectory . '/shopsys/composer.json';
    }
}
