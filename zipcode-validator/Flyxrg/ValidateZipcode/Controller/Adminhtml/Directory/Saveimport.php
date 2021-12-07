<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Controller\Adminhtml\Directory;

use Flyxrg\ValidateZipcode\Model\ZipcodeFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class Save Import File
 * @package Flyxrg\ValidateZipcode\Controller\Adminhtml\Directory
 */
class Saveimport extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Flyxrg_ValidateZipcode::zipcode_saveimport';

    /**
     * @var ZipcodeFactory
     */
    protected $zipcodeFactory;
	
	/**
     * CSV
     */
    private $csv;
	
	/**
     * @var dataHelper
     */
    protected $dataHelper;

    /**
     * Save constructor.
     * @param Context $context
     * @param \Magento\Framework\File\Csv $csv
     * @param ZipcodeFactory $zipcodeFactory
	 * @param \Flyxrg\ValidateZipcode\Helper\Data $dataHelper
     */
    public function __construct(
        Context $context,
        \Magento\Framework\File\Csv $csv,
        ZipcodeFactory $zipcodeFactory,
		\Flyxrg\ValidateZipcode\Helper\Data $dataHelper
    ) {
        parent::__construct($context);
        $this->zipcodeFactory = $zipcodeFactory;
		$this->csv = $csv;
		$this->dataHelper = $dataHelper;
    }

    /**
     * execute
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        try {
			if(isset($data['import_button']))
            {
                $importRawData = $this->csv->getData($_FILES['import_file']['tmp_name']);
                $count = 0;
                foreach ($importRawData as $rowIndex => $dataRow) 
                {
                    if($rowIndex > 0) 
                    {
                        $model = $this->zipcodeFactory->create();
                        $model->setData('country_id', $dataRow[0])
                            ->setData('region_id', $dataRow[1])
                            ->setData('city', $dataRow[2])
                            ->setData('zipcode', $dataRow[3])
                            ->save();

                        $count++;
                    }
                }
                $this->messageManager->addSuccess(__('Total %1 zipcode added successfully.', $count));
            }
            else
                $this->messageManager->addError(__('CSV file not uploaded properly, please try again!'));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }

       return $resultRedirect->setPath('*/*/index');
    }
}