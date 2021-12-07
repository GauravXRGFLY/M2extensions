<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Api\Data;

/**
 * Interface ZipcodeInterface
 *
 * Zipcode Repository Interface.
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Flyxrg\ValidateZipcode\Api
 * @api
 */
interface ZipcodeInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const CATEGORY_ID = 'zipcode_id';
    const COUNTRY_ID = 'country_id';
    const REGION_ID = 'region_id';
    const CITY = 'city';
    const ZIPCODE = 'zipcode';
    /**#@- */

    /**
     * Get ID
     * @return int
     */
    public function getId();

    /**
     * getCountryId
     * @return boolean
     */
    public function getCountryId();

    /**
     * setCountryId
     * @param string $countryId
     * @return mixed
     */
    public function setCountryId($countryId);

    /**
     * getRegionId
     * @return boolean
     */
    public function getRegionId();

    /**
     * setRegionId
     * @param string $regionId
     * @return mixed
     */
    public function setRegionId($regionId);
	
	/**
     * getCity
     * @return boolean
     */
    public function getCity();

    /**
     * setCity
     * @param string $city
     * @return mixed
     */
    public function setCity($city);
	
	/**
     * getZipcode
     * @return boolean
     */
    public function getZipcode();

    /**
     * setZipcode
     * @param string $zipcode
     * @return mixed
     */
    public function setZipcode($zipcode);
}
