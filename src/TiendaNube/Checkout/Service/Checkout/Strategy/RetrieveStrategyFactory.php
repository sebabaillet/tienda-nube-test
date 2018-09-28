<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Checkout\Strategy;

use TiendaNube\Checkout\Http\Client\HttpClientInterface;
use TiendaNube\Checkout\Service\Shipping\AddressService;
use TiendaNube\Checkout\Service\Checkout\Strategy\AddressRetrieveStrategy;
use TiendaNube\Checkout\Model\Store;

final class RetrieveStrategyFactory {

  private static $instance;

  /**
   * gets the instance
   */
  public static function getInstance(): RetrieveStrategyFactory
  {
      if (!self::$instance instanceof self) {
          self::$instance = new self;
      }
      return self::$instance;
  }

  /**
   * Encapsulates the logic that defines how the address is obtained based on
   * store's beta tester condition. Please encapsulate here any other strategies
   * if you need a different one in the future for other store related Business
   * logic rules
   *
   * @param Store $store
   * @param HttpClientInterface $client
   * @param AddressService $addresService
   * @return AddressRetrieveStrategy
   */
  //public function createStrategyForStore(Store $store, ?Client $client, ?AddressService $addresService = null): AddressRetrieveStrategy
  public function createStrategyForStore(Store $store, ?HttpClientInterface $client, ?AddressService $addresService): AddressRetrieveStrategy
  {
      if ($store->isBetaTester()){
        return new ApiStrategy($client);
      }

      return new DatabaseStrategy($addresService);
  }
  /**
   * is not allowed to call from outside to prevent from creating multiple instances,
   * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
   */
  private function __construct()
  {
  }
  /**
   * prevent the instance from being cloned (which would create a second instance of it)
   */
  private function __clone()
  {
  }
  /**
   * prevent from being unserialized (which would create a second instance of it)
   */
  private function __wakeup()
  {
  }
}
