<?php

namespace TiendaNube\Checkout\Service\Checkout\Strategy;

use PHPUnit\Framework\TestCase;
use TiendaNube\Checkout\Service\Checkout\Strategy\ApiStrategy;
use TiendaNube\Checkout\Service\Shipping\AddressService;
use TiendaNube\Checkout\Model\Store;
use TiendaNube\Checkout\Dto\AddressDto;
use TiendaNube\Checkout\Library\Utils\Config;
//Use Guzzle package for mocking api requests
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use TiendaNube\Checkout\Http\Client\HttpClientInterface;
use TiendaNube\Checkout\Http\Client\ClientWrapper;
use TiendaNube\Checkout\Http\Client\ClientAdapter;

class ApiStrategyTest extends TestCase
{
    public function testGetExistingAddressByZip()
    {
        $body = '{
                    "altitude":"7.0",
                    "cep":"40010000",
                   "latitude":"-12.967192",
                   "longitude":"-38.5101976",
                   "address":"Avenida da França",
                     "neighborhood":"Comércio",
                    "city":{
                       "ddd":"71",
                         "ibge":"2927408",
                         "name":"Salvador"
                    },
                    "state":{
                        "acronym":"BA"
                    }
                }';
        $mock = new MockHandler([
            new Response(200, ['Content-Length' => 348, 'Content-Type'=>'application/json', 'server'=>'nginx/1.12.2'],$body),
        ]);
        $handler = HandlerStack::create($mock);

        $guzzleClient = new Client(['handler' => $handler]);
        $client = new ClientAdapter($guzzleClient);
        //$client = new ClientWrapper(['handler' => $handler]);
        $apiStrat = new ApiStrategy($client);
        $result = $apiStrat->getAddressByZip('40010000');
        //make sure we get an array containing the right dto object
        $this->assertNotNull($result);
        $this->assertInstanceOf(AddressDto::class,$result[0]);
        $this->assertEquals('Avenida da França',$result[0]->getAddress());
        $this->assertEquals('Comércio',$result[0]->getNeighborhood());
        $this->assertEquals('Salvador',$result[0]->getCity());
        $this->assertEquals('BA',$result[0]->getState());

    }

    public function testGetNonExistingAddressByZip()
    {
        $mock = new MockHandler([
            new Response(404, ['Content-Length' => 0, 'Content-Type'=>'application/json', 'server'=>'nginx/1.12.2'],""),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new ClientWrapper(['handler' => $handler]);
        $apiStrat = new ApiStrategy($client);
        $result = $apiStrat->getAddressByZip('400100001');
        //verify empty array
        $this->assertNotNull($result);
        $this->assertEmpty($result);
    }

    public function testGetAddressByZipWithServerError()
    {
        $mock = new MockHandler([
            new Response(500, ['Content-Length' => 0, 'Content-Type'=>'application/json', 'server'=>'nginx/1.12.2'],""),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new ClientWrapper(['handler' => $handler]);
        $apiStrat = new ApiStrategy($client);
        $result = $apiStrat->getAddressByZip('40010000');

        $this->assertNull($result);
    }

}
