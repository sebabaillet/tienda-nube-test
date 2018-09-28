<?php

namespace TiendaNube\Checkout\Repository\Shipping;

use PHPUnit\Framework\TestCase;
use TiendaNube\Checkout\Model\Address;

class AddressRepositoryTest extends TestCase
{
    public function testGetExistentAddressByZipcode()
    {
        // expected address
        $address = [
            'address' => 'Avenida da França',
            'neighborhood' => 'Comércio',
            'city' => 'Salvador',
            'state' => 'BA',
        ];

        // mocking statement
        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->method('rowCount')->willReturn(1);
        $stmt->method('fetch')->willReturn($address);

        // mocking pdo
        $pdo = $this->createMock(\PDO::class);
        $pdo->method('prepare')->willReturn($stmt);

        //create the repository
        $addresRepository = new AddressRepository($pdo);

        // testing
        $result = $addresRepository->getAddressByZip('40010000');

        // asserts
        $this->assertNotNull($result);
        $this->assertInstanceOf(Address::class,$result);
        $this->assertEquals('Avenida da França',$result->getAddress());
        $this->assertEquals('Comércio',$result->getNeighborhood());
        $this->assertEquals('Salvador',$result->getCity());
        $this->assertEquals('BA',$result->getState());
    }

    public function testGetNonexistentAddressByZipcode()
    {
        // mocking statement
        $stmt = $this->createMock(\PDOStatement::class);
        $stmt->method('rowCount')->willReturn(0);

        // mocking pdo
        $pdo = $this->createMock(\PDO::class);
        $pdo->method('prepare')->willReturn($stmt);

        //create the repository
        $addresRepository = new AddressRepository($pdo);

        // testing
        $result = $addresRepository->getAddressByZip('40010000');

        // asserts
        $this->assertNull($result);
    }

    public function testExceptionExpected()
    {
        // expects
        $this->expectException(\Exception::class);

        // mocking pdo
        $pdo = $this->createMock(\PDO::class);
        $pdo->method('prepare')->willThrowException(new \Exception('An error occurred'));

        //create the repository
        $addresRepository = new AddressRepository($pdo);

        // testing
        $addresRepository->getAddressByZip('40010000');
    }
}
