<?php

declare(strict_types=1);

namespace App\Util\Repository\Contract;

interface RepositoryInterface
{
    public function getCommit();

    public function getSha(): ?string;

    public function getOwner(): string;

    public function setOwner($owner): void;

    public function getName();

    public function getRepositoryName();

    public function setRepositoryName($repositoryName);
}
