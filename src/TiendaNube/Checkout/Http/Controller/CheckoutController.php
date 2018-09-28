<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Http\Controller;

use Psr\Http\Message\ResponseInterface;
use TiendaNube\Checkout\Service\Checkout\CheckoutService;

class CheckoutController extends AbstractController
{
    /**
     * Returns the address to be auto-fill the checkout form
     *
     * Expected JSON:
     * {
     *     "address": "Avenida da França",
     *     "neighborhood": "Comércio",
     *     "city": "Salvador",
     *     "state": "BA"
     * }
     *
     * @Route /address/{zipcode}
     *
     * @param string $zipcode
     * @param CheckoutService $checkoutService
     * @return ResponseInterface
     */
    public function getAddressAction(string $zipcode, CheckoutService $checkoutService):ResponseInterface {
        // filtering and sanitizing input
        $rawZipcode = preg_replace("/[^\d]/","",$zipcode);

        // getting address by zipcode
        $address = $checkoutService->getAddressByZip($rawZipcode);

        // checking the result
        if (!is_null($address)) {
            if (empty($address)){
              return $this->json(['error'=>'The requested zipcode was not found.'],404);
            }

            return $this->json($address);
        }

        // returning the error when not found
        return $this->json(['error'=>'The server responded with a server error.'],500);
    }
}
