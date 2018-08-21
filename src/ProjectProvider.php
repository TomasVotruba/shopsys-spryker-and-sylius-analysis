<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis;

use Symfony\Component\Console\Input\InputInterface;
use TomasVotruba\ShopsysAnalysis\Configuration\Option;
use TomasVotruba\ShopsysAnalysis\Contract\ProjectInterface;
use TomasVotruba\ShopsysAnalysis\Exception\ProjectNotFoundException;

final class ProjectProvider
{
    /**
     * @var ProjectInterface[]
     */
    private $projects = [];

    /**
     * @var InputInterface
     */
    private $input;

    public function __construct(InputInterface $input)
    {
        $this->input = $input;
    }

    public function addProject(ProjectInterface $project): void
    {
        $this->projects[] = $project;
    }

    /**
     * @return ProjectInterface[]
     */
    public function provide(): array
    {
        $projectOption = $this->input->getOption(Option::PROJECT);
        if (! $projectOption) {
            return $this->projects;
        }

        foreach ($this->projects as $project) {
            if (strtolower($project->getName()) === strtolower($projectOption)) {
                return [$project];
            }
        }

        $this->reportMissingProject($projectOption);
    }

    private function reportMissingProject(string $projectOption): void
    {
        $projectNames = array_map(function (ProjectInterface $project) {
            return $project->getName();
        }, $this->projects);

        throw new ProjectNotFoundException(sprintf(
            'Project "%s" was not found. Available projects are "%s".',
            $projectOption,
            implode('", "', $projectNames)
        ));
    }
}
