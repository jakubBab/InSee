<?php

declare(strict_types=1);

namespace App\Service;

use App\Util\Repository\Contract\RepositoryInterface;
use App\Util\Repository\RepositoryAggregateStorage;

class RepositoryFactory
{
    /** @var RepositoryInterface[] */
    private $repositoriesStorage = [];

    private $owner;

    private $branchName;

    public function __construct(RepositoryAggregateStorage $repositoryAggregateStorage)
    {
        $this->repositoriesStorage = $repositoryAggregateStorage->getRepositories();
    }

    public function isAvailable(string $repoName): bool
    {
        foreach ($this->repositoriesStorage as $repository) {
            if ($repoName == $repository->getName()) {
                return true;
            }
        }

        return false;
    }

    public function getRepositoryByName(string $repoName): RepositoryInterface
    {
        $repository = $this->repositoriesStorage[$repoName];
        $repository->setOwner($this->owner);
        $repository->setBranchName($this->branchName);

        return $this->repositoriesStorage[$repoName];
    }

    public function setOwner($owner): void
    {
        $this->owner = $owner;
    }

    public function setBranchName($branchName): void
    {
        $this->branchName = $branchName;
    }
}
