<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Checkout;

use TiendaNube\Checkout\Http\Client\HttpClientInterface;
use TiendaNube\Checkout\Service\Shipping\AddressService;
use TiendaNube\Checkout\Service\Checkout\Strategy\RetrieveStrategyFactory;
use TiendaNube\Checkout\Service\Checkout\Strategy\AddressRetrieveStrategy;
use TiendaNube\Checkout\Model\Store;

/**
 * Class CheckoutService
 *
 * @package TiendaNube\Checkout\Service\Checkout
 */
class CheckoutService
{

    /**
    * @var Store
    */
    private $store;

    /**
    * @var AddressRetrieveStrategy
    */
    private $retrieveStrategy;

    /**
     * CheckoutService constructor.
     *
     * @param RetrieveStrategyFactory $strategyFactory
     * @param Store $store
     * @param HttpClientInterface $client
     * @param AddressService $addressService

     */
    public function __construct(RetrieveStrategyFactory $strategyFactory,
                                Store $store,
                                ?HttpClientInterface $client,
                                ?AddressService $addressService
                                )
    {
        $this->store = $store;
        $this->retrieveStrategy = $strategyFactory->createStrategyForStore($store, $client, $addressService);
    }

    /**
     * Get address by zip using the right strategy according to current store
     *
     * or false when not found.
     *
     * @param string $zip
     * @return bool|array
     */
    public function getAddressByZip(string $zip): ?array
    {
        return $this->retrieveStrategy->getAddressByZip($zip);
    }

    public function getRetrieveStrategy(){
        return $this->retrieveStrategy;
    }
}
