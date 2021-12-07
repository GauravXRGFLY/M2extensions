<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface ZipcodeSearchResultsInterface
 *
 * FAQ Zipcode Repository Interface.
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Flyxrg\ValidateZipcode\Api
 * @api
 */
interface ZipcodeSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get categories list.
     * @return \Flyxrg\ValidateZipcode\Api\Data\ZipcodeInterface[]
     */
    public function getItems();

    /**
     * Set categories list.
     * @param \Flyxrg\ValidateZipcode\Api\Data\ZipcodeInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
