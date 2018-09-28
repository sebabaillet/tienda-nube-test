<?php

namespace TiendaNube\Checkout\Service\Checkout;


use PHPUnit\Framework\TestCase;
use TiendaNube\Checkout\Model\Store;
use TiendaNube\Checkout\Dto\AddressDto;
use TiendaNube\Checkout\Http\Client\HttpClientInterface;
use TiendaNube\Checkout\Service\Shipping\AddressService;
use TiendaNube\Checkout\Service\Checkout\Strategy\RetrieveStrategyFactory;
use TiendaNube\Checkout\Service\Checkout\Strategy\DatabaseStrategy;
use TiendaNube\Checkout\Service\Checkout\Strategy\ApiStrategy;
use TiendaNube\Checkout\Service\Checkout\CheckoutService;


class CheckoutServiceTest extends TestCase
{
    public function testWillRetrieveAddressFromDatabase()
    {
        //mock a beta tester store
        $betaStore = $this->createMock(Store::class);
        $betaStore->method('isBetaTester')->willReturn(false);

        //mock AddressService
        $addressService = $this->createMock(AddressService::class);
        $addressService->method('getAddressByZip')->willReturn(null);

        //create the factory
        $factory = RetrieveStrategyFactory::getInstance();

        $checkoutService = new CheckoutService($factory,$betaStore, null, $addressService);

        $this->assertInstanceOf(DatabaseStrategy::class, $checkoutService->getRetrieveStrategy());
    }

    public function testWillRetrieveAddressFromApi()
    {
        //mock a beta tester store
        $betaStore = $this->createMock(Store::class);
        $betaStore->method('isBetaTester')->willReturn(true);

        //create the factory and get the right strategy for provided store
        $factory = RetrieveStrategyFactory::getInstance();

        //mock the client
        $client = $this->createMock(HttpClientInterface::class);

        $checkoutService = new CheckoutService($factory,$betaStore, $client, null);

        $this->assertInstanceOf(ApiStrategy::class, $checkoutService->getRetrieveStrategy());
    }
}
