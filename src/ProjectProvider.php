<?php declare(strict_types=1);

namespace TomasVotruba\ShopsysAnalysis;

use TomasVotruba\ShopsysAnalysis\Contract\ProjectInterface;

final class ProjectProvider
{
    /**
     * @var ProjectInterface[]
     */
    private $projects = [];

    public function addProject(ProjectInterface $project): void
    {
        $this->projects[] = $project;
    }

    /**
     * @return ProjectInterface[]
     */
    public function provide(): array
    {
        return $this->projects;
    }
}
