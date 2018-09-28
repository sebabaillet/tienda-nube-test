<?php

namespace TiendaNube\Checkout\Service\Checkout\Strategy;

use PHPUnit\Framework\TestCase;
use TiendaNube\Checkout\Service\Checkout\Strategy\DatabaseStrategy;
use TiendaNube\Checkout\Service\Shipping\AddressService;

class DatabaseStrategyTest extends TestCase
{
    public function testGetExistingAddressByZip()
    {
        // expected address
        $address = [
            'address' => 'Avenida da França',
            'neighborhood' => 'Comércio',
            'city' => 'Salvador',
            'state' => 'BA',
        ];

        // mock addressService
        $addressService = $this->createMock(AddressService::class);
        $addressService->method('getAddressByZip')->willReturn($address);

        $databaseStrategy = new DatabaseStrategy($addressService);

        // test
        $result = $databaseStrategy->getAddressByZip('40010000');

        // asserts
        $this->assertEquals($address, $result);
    }

    public function testGetNonExistingAddressByZip()
    {
        // mock addressService
        $addressService = $this->createMock(AddressService::class);
        $addressService->method('getAddressByZip')->willReturn(null);

        $databaseStrategy = new DatabaseStrategy($addressService);

        // test
        $result = $databaseStrategy->getAddressByZip('400100001');

        // asserts
        $this->assertNull($result);
    }

}
