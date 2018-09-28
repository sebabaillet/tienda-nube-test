<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Http\Client;

use Psr\Http\Message\ResponseInterface;
use  GuzzleHttp\Client;

/**
 * Class ClientWrapper
 * Wraps guzzle client. Adapts it to defined interface and inherits all of its
 * methods. Only made this in case I need anything for unit testing.
 *
 * @package TiendaNube\Checkout\Http\Client;
 */
class ClientWrapper extends Client implements HttpClientInterface
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /* @param string $method
     * @param string $uri
     * @param arrray $options
     * @return ResponseInterface
     */
    public function sendRequest(string $method, string $uri = '', array $options = []): ResponseInterface
    {
        return parent::request($method, $uri ,  $options );
    }

}
