<?php

declare(strict_types=1);

namespace App\Util\Repository\Contract;

abstract class AbstractRepository implements RepositoryInterface
{
    protected $name = 'github';

    protected $owner;

    protected $repositoryName;

    abstract public function getCommit();

    abstract public function getSha(): ?string;

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function setOwner($owner): void
    {
        $this->owner = $owner;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRepositoryName(): string
    {
        return $this->repositoryName;
    }

    public function setRepositoryName($repositoryName): void
    {
        $this->repositoryName = $repositoryName;
    }
}
