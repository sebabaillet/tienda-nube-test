<?php

declare(strict_types=1);

namespace TiendaNube\Checkout\Dto;

/**
 * Class AddressDto
 * Based on provided sql statement (select * from addresses) and the returned
 * array, I assume the fields for this dto. Accordin to provided comment:
 * The expected return format is an array like:
 * [
 *      "address" => "Avenida da França",
 *      "neighborhood" => "Comércio",
 *      "city" => "Salvador",
 *      "state" => "BA"
 * ]
 * @package TiendaNube\Checkout\Dto
 */
class AddressDto
{
    /**
     * The address itself
     *
     * @var string
     */
    private $addres;

    /**
     * The neighborhood
     *
     * @var string
     */
    private $neighborhood;

    /**
     * The city
     *
     * @var string
     */
    private $city;

    /**
     * The state
     *
     * @var string
     */
    private $state;
    
    
    public function __construct(string $address = "", string $neighborhood = "" , string $state = "" , string $city = "")
    {
        $this->address = $address;
        $this->neighborhood = $neighborhood;
        $this->state = $state;
        $this->city = $city;
    }
    

    /**
     * Get the address
     *
     * @return string
     */
    public function getAddress():string {
        return $this->address;
    }

    /**
     * Set the address
     *
     * @param string $address
     */
    public function setAddress(string $address):void {
        $this->address = $address;
    }

    /**
     * Set the neighborhood
     *
     * @param string $neighborhood
     */
    public function setNeighborhood(string $neighborhood):void {
        $this->neighborhood = $neighborhood;
    }

    /**
     * Get the neighborhood
     *
     * @return string
     */
    public function getNeighborhood():string {
        return $this->neighborhood;
    }

    /**
     * Sets the city
     *
     * @param string $city
     */
    public function setCity(string $city):void {
        $this->city = $city;
    }

    /**
     * Get the city
     * @return string
     */
    public function getCity():string {
        return $this->city;
    }

    /**
     * Sets the state
     *
     * @param string $sate
     */
    public function setState(string $state):void {
        $this->state = $state;
    }

    /**
     * Get the state
     * @return string
     */
    public function getState():string {
        return $this->state;
    }

}
