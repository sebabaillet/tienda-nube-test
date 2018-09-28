<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Repository\Shipping;

use TiendaNube\Checkout\Model\Address;

/**
 * Class AddressRepository
 *
 * @package TiendaNube\Checkout\Repository\Shipping
 */
class AddressRepository
{
   /**
   * The database connection link
   *
   * @var \PDO
   */
    private $connection;


    /**
     * AddressRepository constructor.
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->connection = $pdo;
    }

    /**
     * Get an address by its zipcode (CEP)
     *
     * The expected return format is an Address DTO object containing this info:
     * [
     *      "address" => "Avenida da França",
     *      "neighborhood" => "Comércio",
     *      "city" => "Salvador",
     *      "state" => "BA"
     * ]
     * or null when not found.
     *
     * @param string $zip
     * @return Address
     */
    public function getAddressByZip(string $zip): ?Address
    {
        // getting the address from database
        $stmt = $this->connection->prepare('SELECT * FROM `addresses` WHERE `zipcode` = ?');
        $stmt->execute([$zip]);

        // checking if the address exists
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            $address = new Address();
            $address->setAddress($result["address"]);
            $address->setCity($result["city"]);
            $address->setState($result["state"]);
            $address->setNeighborhood($result["neighborhood"]);

            return $address;
        }

        return null;
    }
}
