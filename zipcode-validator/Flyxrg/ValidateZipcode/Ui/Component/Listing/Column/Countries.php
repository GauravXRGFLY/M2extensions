<?php
declare(strict_types=1);
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Flyxrg\ValidateZipcode\Ui\Component\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class for process countries in zipcode grid
 */
class Countries implements OptionSourceInterface
{
    /**
     * @var \Magento\Directory\Model\ResourceModel\Country\CollectionFactory
     */
    private $countryCollectionFactory;

    /**
     * @param \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $collectionFactory
    ) {
        $this->countryCollectionFactory = $collectionFactory;
    }

    /**
     * Get list of countries with country id as value and code as label
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        /** @var \Magento\Directory\Model\ResourceModel\Country\Collection $countryCollection */
        $countryCollection = $this->countryCollectionFactory->create();
        return $countryCollection->toOptionArray();
    }
}
