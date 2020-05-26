<?php

declare(strict_types=1);

namespace App\Util\Request;

use App\Util\Request\Contract\RequestInterface;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\HttpClient;

class RequestHttpClient implements RequestInterface
{
    protected $client;

    protected $content;

    protected $headers = [];

    public function __construct()
    {
        $this->client = HttpClient::create();
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function call(string $method, $url): bool
    {
        $headers = !empty($headers) ? ['headers' => $this->headers] : [];

        try {
            $this->content = $this->client->request($method, $url, $headers);
        } catch (TransportException $exception) {
            return false;
        }

        return true;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getContentAsArray(): array
    {
        return empty($this->content) ? [] : $this->content->toArray();
    }
}
