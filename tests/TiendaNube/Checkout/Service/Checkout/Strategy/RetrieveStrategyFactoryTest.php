<?php

namespace TiendaNube\Checkout\Service\Checkout\Strategy;

use PHPUnit\Framework\TestCase;
use TiendaNube\Checkout\Model\Store;
use TiendaNube\Checkout\Http\Client\HttpClientInterface;
use TiendaNube\Checkout\Service\Checkout\Strategy\RetrieveStrategyFactory;
use TiendaNube\Checkout\Service\Checkout\Strategy\ApiStrategy;
use TiendaNube\Checkout\Service\Checkout\Strategy\DatabaseStrategy;
use TiendaNube\Checkout\Service\Shipping\AddressService;

class RetrieveStrategyFactoryTest extends TestCase
{
    public function testCanCreateApiStrategy()
    {
        //mock a beta tester store
        $betaStore = $this->createMock(Store::class);
        $betaStore->method('isBetaTester')->willReturn(true);

        //mock the client
        $client = $this->createMock(HttpClientInterface::class);

        //create the factory and get the right strategy for provided store
        $factory = RetrieveStrategyFactory::getInstance();
        $strategy = $factory->createStrategyForStore($betaStore, $client, null);

        $this->assertInstanceOf(ApiStrategy::class, $strategy);
    }

    public function testCanCreateDatabaseStrategy()
    {
        //mock a non beta tester store
        $betaStore = $this->createMock(Store::class);
        $betaStore->method('isBetaTester')->willReturn(false);

        //mock address Service
        $addresService = $this->createMock(AddressService::class);

        //create the factory and get the right strategy for provided store
        $factory = RetrieveStrategyFactory::getInstance();
        $strategy = $factory->createStrategyForStore($betaStore, null, $addresService);

        $this->assertInstanceOf(DatabaseStrategy::class, $strategy);
    }
}
