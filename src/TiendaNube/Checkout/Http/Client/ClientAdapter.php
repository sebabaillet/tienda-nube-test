<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Http\Client;

use Psr\Http\Message\ResponseInterface;
use  GuzzleHttp\Client;

/**
 * Class ClientWrapper
 * Adapter for guzzle http client. will use it for unit tests since I want to
 * take advantage of its response mocking capabilities
 * @package TiendaNube\Checkout\Http\Client;
 */
class ClientAdapter implements HttpClientInterface
{
    /**
    * @var Client
    */
    private $client;

    public function __construct(Client $client)
    {
      $this->client = $client;
    }

    /* @param string $method
     * @param string $uri
     * @param arrray $options
     * @return ResponseInterface
     */
    public function sendRequest(string $method, string $uri = '', array $options = []): ResponseInterface
    {
        return $this->client->request($method, $uri ,  $options );
    }

}
