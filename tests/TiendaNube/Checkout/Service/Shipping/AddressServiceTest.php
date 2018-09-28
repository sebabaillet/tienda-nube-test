<?php

namespace TiendaNube\Checkout\Service\Shipping;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use TiendaNube\Checkout\Repository\Shipping\AddressRepository;
use TiendaNube\Checkout\Dto\AddressDto;
use TiendaNube\Checkout\Model\Address;

class AddressServiceTest extends TestCase
{
    public function testGetExistentAddressByZipcode()
    {
        //mock expected address
        $address = $this->createMock(Address::class);
        $address->method('getAddress')->willReturn("Avenida da França");
        $address->method('getNeighborhood')->willReturn("Comércio");
        $address->method('getCity')->willReturn("Salvador");
        $address->method('getState')->willReturn("BA");

        // mock repository
        $repository = $this->createMock(AddressRepository::class);
        $repository->method('getAddressByZip')->willReturn($address);

        // mock logger
        $logger = $this->createMock(LoggerInterface::class);

        // creating service
        $service = new AddressService($repository,$logger);

        // testing
        $result = $service->getAddressByZip('40010000');

        // asserts
        $this->assertNotNull($result);
        $this->assertInstanceOf(AddressDto::class,$result[0]);
    }

    public function testGetNonexistentAddressByZipcode()
    {
        // mock repository
        $repository = $this->createMock(AddressRepository::class);
        $repository->method('getAddressByZip')->willReturn(null);

        // mock logger
        $logger = $this->createMock(LoggerInterface::class);

        // creating service
        $service = new AddressService($repository,$logger);

        // testing
        $result = $service->getAddressByZip('40010001');

        // asserts
        $this->assertEmpty($result);
    }

    public function testGetAddressByZipcodeWithPdoException()
    {
        // mock repository
        $repository = $this->createMock(AddressRepository::class);
        $repository->method('getAddressByZip')->willThrowException(new \PDOException('An error occurred'));

        // mock logger
        $logger = $this->createMock(LoggerInterface::class);

        // creating service
        $service = new AddressService($repository,$logger);

        // testing
        $result = $service->getAddressByZip('40010000');

        // asserts
        $this->assertNull($result);
    }

    public function testGetAddressByZipcodeWithUncaughtException()
    {
        // expects
        $this->expectException(\Exception::class);

        // mock repository
        $repository = $this->createMock(AddressRepository::class);
        $repository->method('getAddressByZip')->willThrowException(new \Exception('An error occurred'));

        // mock logger
        $logger = $this->createMock(LoggerInterface::class);

        // creating service
        $service = new AddressService($repository,$logger);

        // testing
        $service->getAddressByZip('40010000');
    }
}
