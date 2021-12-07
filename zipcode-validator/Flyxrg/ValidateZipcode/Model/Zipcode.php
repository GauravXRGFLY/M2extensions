<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Model;

use Flyxrg\ValidateZipcode\Api\Data\ZipcodeInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Directory Zipcode
 * @package Flyxrg\ValidateZipcode\Model
 */
class Zipcode extends AbstractModel implements IdentityInterface, ZipcodeInterface
{
    /**
     * News Zipcode cache tag
     */
    const CACHE_TAG = 'zipcode_directory';

    /**
     * ID_FIELD_NAME
     */
    const ID_FIELD_NAME = 'zipcode_id';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_idFieldName = self::ID_FIELD_NAME;

    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init('Flyxrg\ValidateZipcode\Model\ResourceModel\Zipcode');
    }

    /**
     * getIdentities
     * @return array
     */
    public function getIdentities()
    {
        return [
            self::CACHE_TAG . '_' . $this->getId(),
            self::CACHE_TAG . '_' . $this->getCode()
        ];
    }
	
	public function loadByZipcode($zipcode)
	{
		$id = $this->getResource()->loadByZipcode($zipcode);
		return $this->load($id);
	}

    /**
     * getEntityId
     * @return mixed|string
     */
    public function getEntityId()
    {
        return $this->getData('entity_id');
    }

    /**
     * setEntityId
     * @param string $entityId
     * @return $this|mixed
     */
    public function setEntityId($entityId)
    {
        return $this->setData('entity_id', $entityId);
    }

    /**
     * getCountryId
     * @return mixed|string
     */
    public function getCountryId()
    {
        return $this->getData('country_id');
    }

    /**
     * setCountryId
     * @param string $countryId
     * @return $this|mixed
     */
    public function setCountryId($countryId)
    {
        return $this->setData('country_id', $countryId);
    }
	
	/**
     * getRegionId
     * @return mixed|string
     */
    public function getRegionId()
    {
        return $this->getData('region_id');
    }

    /**
     * setRegionId
     * @param string $regionId
     * @return $this|mixed
     */
    public function setRegionId($regionId)
    {
        return $this->setData('region_id', $regionId);
    }
	
	/**
     * getCity
     * @return mixed|string
     */
    public function getCity()
    {
        return $this->getData('city');
    }

    /**
     * setCity
     * @param string $city
     * @return $this|mixed
     */
    public function setCity($city)
    {
        return $this->setData('city', $city);
    }
	
	/**
     * getZipcode
     * @return mixed|string
     */
    public function getZipcode()
    {
        return $this->getData('zipcode');
    }

    /**
     * setZipcode
     * @param string $zipcode
     * @return $this|mixed
     */
    public function setZipcode($zipcode)
    {
        return $this->setData('zipcode', $zipcode);
    }
}
