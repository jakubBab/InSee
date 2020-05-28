<?php

declare(strict_types=1);

namespace App\Util\Request;

use App\Util\Request\Contract\RequestInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;

class RequestHttpClient implements RequestInterface
{
    protected $client;

    protected $content;

    protected $headers = [];

    public function __construct()
    {
        $this->client = HttpClient::create();
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function call(string $method, $url): bool
    {
        $headers = !empty($this->headers) ? ['headers' => $this->headers] : [];

        try {
            $response = $this->client->request($method, $url, $headers);
            if (Response::HTTP_OK !== $response->getStatusCode()) {
                return false;
            }
        } catch (\Exception $exception) {
            return false;
        }
        $this->content = $response;

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
