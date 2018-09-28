<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Shipping;

use Psr\Log\LoggerInterface;
use TiendaNube\Checkout\Repository\Shipping\AddressRepository;
use TiendaNube\Checkout\Dto\AddressDto;
use TiendaNube\Checkout\Model\Address;


/**
 * Class AddressService
 *
 * @package TiendaNube\Checkout\Service\Shipping
 */
class AddressService
{
   /**
   * The database connection link
   *
   * @var \PDO
   */
    private $connection;

   /**
   * Address Repository
   *
   * @var AddressRepository
   */
    private $addresRepository;

    private $logger;

    /**
     * AddressService constructor.
     *
     * @param AddressRepository $addresRepository
     * @param LoggerInterface $logger
     */
    public function __construct(AddressRepository $addresRepository, LoggerInterface $logger)
    {
        $this->addresRepository = $addresRepository;
        $this->logger = $logger;
    }

    /**
     * Get an address by its zipcode (CEP)
     *
     * The expected return format is an array containing an address object
     * [Address]
     * or
     * [] empty array if not found
     *
     * null is returned in case of error.
     *
     * @param string $zip
     * @return bool|array
     */
    public function getAddressByZip(string $zip): ?array
    {
        $this->logger->debug('Getting address for the zipcode [' . $zip . '] from database');

        try {
            if($this->addresRepository->getAddressByZip($zip))
              return [$this->getAddresDtoObject($this->addresRepository->getAddressByZip($zip))];

            return[];
        } catch (\PDOException $ex) {

            $this->logger->error(
                'An error occurred at try to fetch the address from the database, exception with message was caught: ' .
                $ex->getMessage()
            );

            return null;
        } 
    }
    
    /**
     * Transforms a model into a dto object. in this case is trivial
     *
     * @param Address $address
     * @return AddressDto
     */
    private function getAddresDtoObject(Address $address): AddressDto
    {
        return new AddressDto($address->getAddress(),
                              $address->getNeighborhood(),
                              $address->getState(),
                              $address->getCity()
                              );
    }
}
