<?php

declare(strict_types=1);

namespace App\Util\Request\Contract;

interface RequestInterface
{
    public function setHeaders(array $headers);

    public function call(string $method, $url): bool;

    public function getContent();

    public function getContentAsArray(): array;
}
