<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Library\Utils;

/**
 * Class Config
 *
 * @package TiendaNube\Checkout\Library\Utils;
 */
abstract class Config 
{ 
    const SHIPPING_API_URL = "https://shipping.tiendanube.com/v1/";
    const SHIPPING_API_ADDRESS_ENDPOINT = "address/";
    const SHIPPING_API_AUTH_TOKEN = "YouShallNotPass";
   
}
