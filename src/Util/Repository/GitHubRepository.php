<?php

declare(strict_types=1);

namespace App\Util\Repository;

use App\Util\Repository\Contract\AbstractRepository;
use App\Util\Request\Contract\RequestInterface;

class GitHubRepository extends AbstractRepository
{
    /** @var RequestInterface */
    private $gitHubRequest;

    private $host = 'https://api.github.com';

    private $headers = [
        'Accept' => 'application/vnd.github.v3+json',
    ];

    private $commits = '/repos/lexik/LexikJWTAuthenticationBundle/commits/master';

    private $isSuccess = false;

    public function __construct(RequestInterface $gitHubRequest)
    {
        $this->gitHubRequest = $gitHubRequest;
    }

    public function getCommit()
    {
        $this->gitHubRequest->setHeaders($this->getHeaders());
        $endpoint = $this->buildUrl($this->getCommits());
        $this->isSuccess = $this->gitHubRequest->call('GET', $endpoint);

        return !$this->isSuccess ? [] : $this->gitHubRequest->getContentAsArray();
    }

    public function getSha(): ?string
    {
        if (!$this->isSuccess) {
            return null;
        }
        $content = $this->gitHubRequest->getContentAsArray();
        if (!array_key_exists('sha', $content)) {
            return null;
        }

        return $content['sha'];
    }

    private function buildUrl($resource)
    {
        return sprintf('%s%s', $this->host, $resource);
    }

    private function getHeaders()
    {
        return $this->headers;
    }

    private function getCommits()
    {
        return $this->commits;
    }
}
