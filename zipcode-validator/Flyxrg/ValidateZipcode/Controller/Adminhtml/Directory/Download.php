<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Controller\Adminhtml\Directory;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;

/**
 * Class Download
 * @package Flyxrg\ValidateZipcode\Controller\Adminhtml\Directory
 */
class Download extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Flyxrg_ValidateZipcode::zipcode_download';

	/**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;
	
	/**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;
    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvProcessor;
    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $directoryList;
		
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param Context $context
	 * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Framework\View\Result\LayoutFactory     $resultLayoutFactory
     * @param \Magento\Framework\File\Csv                      $csvProcessor
     * @param \Magento\Framework\App\Filesystem\DirectoryList  $directoryList
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
		\Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Framework\File\Csv $csvProcessor,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
		$this->fileFactory = $fileFactory;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->csvProcessor = $csvProcessor;
        $this->directoryList = $directoryList;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * CSV Create and Download
     *
     * @return ResponseInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function execute()
    {
        /** Add yout header name here */
        $content[] = [
            'country_id' => __('Country ID'),
            'region_id' => __('Region ID'),
            'city' => __('City'),
            'zipcode' => __('Zipcode'),
        ];
		
		$resultLayout = $this->resultLayoutFactory->create();
        $collection = $this->zipcodeFactory->create()->getCollection();
        
        $fileName = 'zipcodes_sample.csv';
        $filePath =  $this->directoryList->getPath(DirectoryList::MEDIA) . "/" . $fileName;
		$content[] = [
			"US",
			"Elexa",
			"NYC",
			"65985"
		];
		
        $this->csvProcessor->setEnclosure('"')->setDelimiter(',')->saveData($filePath, $content);
        return $this->fileFactory->create(
            $fileName,
            [
                'type'  => "filename",
                'value' => $fileName,
                'rm'    => true,
            ],
            DirectoryList::MEDIA,
            'text/csv',
            null
        );
    }
}
