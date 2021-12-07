<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Api;

use Flyxrg\ValidateZipcode\Api\Data\ZipcodeInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface ZipcodeRepositoryInterface
 *
 * FAQ Zipcode Repository Interface.
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Flyxrg\ValidateZipcode\Api
 * @api
 */
interface ZipcodeRepositoryInterface
{
    /**
     * Save zipcode.
     *
     * @param \Flyxrg\ValidateZipcode\Api\Data\ZipcodeInterface $zipcode
     * @return \Flyxrg\ValidateZipcode\Api\Data\ZipcodeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(ZipcodeInterface $zipcode);

    /**
     * Retrieve zipcode.
     *
     * @param int $zipcodeId
     * @return \Flyxrg\ValidateZipcode\Api\Data\ZipcodeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($zipcodeId);

    /**
     * Retrieve categories matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Flyxrg\ValidateZipcode\Api\Data\ZipcodeSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete zipcode.
     *
     * @param \Flyxrg\ValidateZipcode\Api\Data\ZipcodeInterface $zipcode
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(ZipcodeInterface $zipcode);

    /**
     * Delete zipcode by ID.
     *
     * @param int $zipcodeId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($zipcodeId);
}
