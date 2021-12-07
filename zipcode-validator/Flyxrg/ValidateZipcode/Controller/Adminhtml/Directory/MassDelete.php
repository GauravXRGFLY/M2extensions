<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Controller\Adminhtml\Directory;

use Flyxrg\ValidateZipcode\Model\Zipcode;
use Flyxrg\ValidateZipcode\Model\ResourceModel\Zipcode as ResourceModel;
use Flyxrg\Faq\Model\ResourceModel\Category\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete
 * @package Flyxrg\ValidateZipcode\Controller\Adminhtml
 */
class MassDelete extends Action
{
    /**
     * ADMIN_RESOURCE
     */
    const ADMIN_RESOURCE = 'Flyxrg_ValidateZipcode::zipcode_massdelete';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var ResourceModel
     */
    protected $resourceModel;
	
	/**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * MassEnable constructor.
     * @param Context $context
     * @param Filter $filter
	 * @param CollectionFactory $collectionFactory
     * @param ResourceModel $resourceModel
     */
    public function __construct(
        Context $context,
        Filter $filter,
		CollectionFactory $collectionFactory,
        ResourceModel $resourceModel
    ) {
        parent::__construct($context);
        $this->filter = $filter;
		$this->collectionFactory = $collectionFactory;
        $this->resourceModel = $resourceModel;
    }

    /**
     * execute
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
        } catch (Exception $e) {
            throw new \Exception($e);
        }

        $collectionSize = $collection->getSize();

        /** @var Zipcode $item */
        foreach ($collection as $item) {
            try {
                $this->resourceModel->delete($item);
            } catch (Exception $e) {
                throw new \Exception($e);
            }
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been deleted.', $collectionSize)
        );

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
