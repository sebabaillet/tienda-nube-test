<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Checkout\Strategy;

use TiendaNube\Checkout\Service\Shipping\AddressService;

/**
 * Class DatabaseStrategy
 *
 * @package TiendaNube\Checkout\Service\Checkout\Strategy
 */
class DatabaseStrategy implements AddressRetrieveStrategy
{
    private $addressService;

  /**
   * DatabaseStrategy constructor.
   *
   * @param AddressService $addressService
   */
    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    /**
     * Gets address by zip code via the already implemented address serv.
     *
     * @param string $zip
     * @return bool|array
     */
    public function getAddressByZip(string $zip): ?array
    {
        return $this->addressService->getAddressByZip($zip);
    }

}
