<?php

namespace Flyxrg\ValidateZipcode\Controller\Ajax;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class Result extends \Magento\Framework\App\Action\Action
{
     /**
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

	/**
     * @var JsonFactory
     */
    protected $resultJsonFactory;
	
	/**
     * @var ZipcodeFactory
     */
    protected $zipcodeFactory;
	
	/**
     * @var \Magento\Framework\Json\Helper\Data $helper
     */
    protected $helper;

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
	 * @param JsonFactory $resultJsonFactory
	 * @param \Magento\Framework\Json\Helper\Data $helper
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
		\Magento\Framework\Json\Helper\Data $helper,
		\Flyxrg\ValidateZipcode\Model\ZipcodeFactory $zipcodeFactory
        )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
		$this->helper = $helper;
		$this->zipcodeFactory = $zipcodeFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
		$response = [];
        $result = $this->resultJsonFactory->create();
        $resultPage = $this->resultPageFactory->create();
		
		$data = $this->helper->jsonDecode($this->getRequest()->getContent());
		if(isset($data['postcode']))
		{
			$zipcode = $this->zipcodeFactory->create()->load($data['postcode'],"zipcode");
			if($zipcode !== null)
			{
				$response['country_id'] = $zipcode->getCountryId();
				$response['city'] = $zipcode->getCity();
				$response['region_id'] = $zipcode->getRegionId();
			}
		}
		
        $result->setData($response);
        return $result;
    }
}