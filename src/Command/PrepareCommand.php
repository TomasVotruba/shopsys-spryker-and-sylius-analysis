<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis\Command;

use Nette\Utils\FileSystem;
use Nette\Utils\Json;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
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
        $this->createProcessOutputAndRun(
            'git clone https://github.com/shopsys/shopsys.git --depth 1 --single-branch --branch v7.0.0-alpha4 project/shopsys'
        );

        $this->prepareShopsysComposerJson();
        $this->symfonyStyle->note('Shopsys composer.json cleaned up');

        $this->createProcessOutputAndRun('composer install --working-dir project/shopsys --no-dev --no-interaction');
        $this->createProcessOutputAndRun('rm -rf project/shopsys/vendor/nikic project/shopsys/vendor/phpstan');
        $this->symfonyStyle->success('Install of Shopsys done');

        // @todo fix
        // - https://api.github.com/repos/molaux/PostgreSearchBundle unable to install

        // sylius
        $this->createProcessOutputAndRun(
            'git clone https://github.com/Sylius/Sylius.git --depth 1 --single-branch --branch v1.2.4 project/sylius'
        );
        $this->createProcessOutputAndRun('composer install --working-dir project/sylius --no-dev --no-interaction');
        $this->symfonyStyle->success('Install of Sylius done');

        // spryker
        $this->createProcessOutputAndRun(
            'git clone https://github.com/spryker/demoshop --depth 1 --single-branch --branch 2.32 project/spryker'
        );
        $this->createProcessOutputAndRun('composer install --working-dir project/spryker --no-dev --no-interaction');
        $this->symfonyStyle->success('Install of Spryker done');

        // success
        return 0;
    }

    private function getShopsysComposerJsonFilePath(): string
    {
        return $this->projectsDirectory . '/shopsys/composer.json';
    }

    private function prepareShopsysComposerJson(): void
    {
        // load
        $shopsysComposerJson = FileSystem::read($this->getShopsysComposerJsonFilePath());
        $shopsysComposerData = Json::decode($shopsysComposerJson, Json::FORCE_ARRAY);

        // fix long install run on Doctrine custom branch
        $shopsysComposerData['require']['doctrine/orm'] = '^2.6';

        // save
        $shopsysComposerJson = Json::encode($shopsysComposerData, Json::PRETTY);
        FileSystem::write($this->getShopsysComposerJsonFilePath(), $shopsysComposerJson);
    }

    private function createProcessOutputAndRun(string $commandLine): void
    {
        $process = new Process($commandLine, null, null, null, 200.0);
        $this->symfonyStyle->note('Running: ' . $process->getCommandLine());

        $process->run();

        // report output
        if ($process->getOutput()) {
            $this->symfonyStyle->note($process->getOutput());
        } elseif ($process->getErrorOutput()) {
            $this->symfonyStyle->error($process->getErrorOutput());
        }
    }
}
