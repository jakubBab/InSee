<?php

declare(strict_types=1);

namespace App\Controller\Services;

use App\Util\Repository\Contract\RepositoryInterface;

class RepositoryFactory
{
    /** @var RepositoryInterface[] */
    private $repositoriesStorage = [];

    public function __construct(RepositoryInterface $gitHubRepository)
    {
        $this->repositoriesStorage[$gitHubRepository->getName()] = $gitHubRepository;
    }

    public function isAvailable(string $repoName)
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
        return $this->repositoriesStorage[$repoName];
    }
}
