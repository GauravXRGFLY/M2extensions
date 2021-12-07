<?php
namespace Flyxrg\ValidateZipcode\Helper;

use Magento\Directory\Model\RegionFactory;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{	
	/**
     * @var regionFactory
     */
	protected $regionFactory;
	
	/**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param RegionFactory $regionFactory
     */
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		RegionFactory $regionFactory
	) 
	{
		$this->regionFactory = $regionFactory;
		parent::__construct($context);
	}
	
	public function getRegionName($regionId)
	{
		$region = $this->regionFactory->create()->load($regionId);
		return $region->getDefaultName();
	}
}