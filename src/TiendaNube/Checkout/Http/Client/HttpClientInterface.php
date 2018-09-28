<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Http\Client;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    /**
     * Decouple client implementation.
     * Any client can be used by implementing a simple adapter
     *
     * @param string $method
     * @param string $uri
     * @param arrray $options
     * @return ResponseInterface
     */
    public function sendRequest(string $method, string $uri = '', array $options = []): ResponseInterface;
}
