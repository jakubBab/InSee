<?php

declare(strict_types=1);

namespace App\Util\Repository;

use App\Util\Repository\Contract\RepositoryInterface;

class RepositoryAggregateStorage
{
    private $repositoriesStorage;

    public function __construct(
        RepositoryInterface $gitHubRepository
    ) {
        $this->addRepositoryToStorage([$gitHubRepository]);
    }

    /**
     * @param RepositoryInterface[] $repositories
     */
    private function addRepositoryToStorage(array $repositories)
    {
        /** @var RepositoryInterface $repository */
        foreach ($repositories as $repository) {
            $this->repositoriesStorage[$repository->getName()] = $repository;
        }
    }

    public function getRepositories(): array
    {
        return $this->repositoriesStorage;
    }
}
