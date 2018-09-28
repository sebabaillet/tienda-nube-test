<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Service\Checkout\Strategy;

use TiendaNube\Checkout\Http\Client\HttpClientInterface;
use TiendaNube\Checkout\Http\Client\ClientWrapper;
use TiendaNube\Checkout\Library\Utils\Config;
use TiendaNube\Checkout\Dto\AddressDto;

/**
 * Class ApiStrategy
 *
 * @package TiendaNube\Checkout\Service\Checkout\Strategy
 */
class ApiStrategy implements AddressRetrieveStrategy
{
    /**
     * The http client
     *
     * @var HttpClientInterface $client
     */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Expectedes responses according to early specification:
     * Gets address by zip code via the new RESTful API.
     *
     * @param string $zip
     *
     * Expected Return from api
     * HTTP/1.1 200 OK
     *  Server: nginx/1.12.2
     *  Content-Type: application/json
     *  Content-Length: 308
     *
     *  {
     *      "altitude":"7.0", //added quotes
     *      "cep":"40010000",
     *      "latitude":"-12.967192",
     *      "longitude":"-38.5101976",
     *     "address":"Avenida da França",
     *      "neighborhood":"Comércio",
     *      "city":{
     *         "ddd":"71", //added quotes
     *           "ibge":"2927408",
     *           "name":"Salvador"
     *      },
     *      "state":{
     *          "acronym":"BA"
     *      }
     *  }
     *  ```
     *
     *  #### Nonexistent Address
     *  ```
     *  $ curl -XGET -H 'Authentication bearer: YouShallNotPass' -H "Content-type: application/json" https://shipping.tiendanube.com/address/400100001
     *
     *  HTTP/1.1 404 Not Found
     *  Server: nginx/1.12.2
     *  Content-Type: application/json
     *  Content-Length: 0
     *   ```
     *
     *  #### Server Error
     *  ```
     *  $ curl -XGET -H 'Authentication bearer: YouShallNotPass' -H "Content-type: application/json" https://shipping.tiendanube.com/address/40010000
     *
     *  HTTP/1.1 500 Internal Server Error
     *  Server: nginx/1.12.2
     *  Content-Type: application/json
     *  Content-Length: 0
     *  ```
     *
     */
    public function getAddressByZip(string $zip): ?array
    {
       $headers=['Authorization' => 'Bearer: '.Config::SHIPPING_API_AUTH_TOKEN , 'Content-type' => 'application/json'];

       try
       {
           $response = $this->client->sendRequest('GET', Config::SHIPPING_API_URL . Config::SHIPPING_API_ADDRESS_ENDPOINT . $zip, ['headers' => $headers]);
           $addressData = json_decode($response->getBody()->getContents(), true);
           $address = new AddressDto();
           $address->setAddress($addressData["address"]);
           $address->setCity($addressData["city"]["name"]);
           $address->setState($addressData["state"]["acronym"]);
           $address->setNeighborhood($addressData["neighborhood"]);

           return [$address];

       }catch (\Exception $e){
            //if address not found
            if($e->getResponse()->getStatusCode() == 404)
              return[];

            //if server error
            return null;
        }

       return null;
    }
}
