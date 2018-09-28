<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Checkout\Strategy;


/**
 * Interface AddressRetrieveInterface
 *
 * @package TiendaNube\Checkout\Service\Checkout\Strategy
 */
interface AddressRetrieveStrategy
{
    /**
     * Get the requested addres according to provided zip coce
     * @param string $zip
     * @return bool|array
     */
    public function getAddressByZip(string $zip): ?array;
}
