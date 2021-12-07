<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Model\ResourceModel\Zipcode;

use Flyxrg\ValidateZipcode\Model\Category;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Flyxrg\ValidateZipcode\Model\ResourceModel\Zipcode
 */
class Collection extends AbstractCollection
{
    /**
     * _construct
     */
    public function _construct()
    {
        $this->_init(
            'Flyxrg\ValidateZipcode\Model\Zipcode',
            'Flyxrg\ValidateZipcode\Model\ResourceModel\Zipcode'
        );
    }
}
