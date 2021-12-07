<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Controller\Adminhtml\Directory;

use Flyxrg\ValidateZipcode\Api\ZipcodeRepositoryInterface;
use Flyxrg\ValidateZipcode\Model\ZipcodeFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

/**
 * Class Delete
 *
 * FAQ Backend Zipcode Delete Controller.
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Flyxrg\ValidateZipcode\Controller\Adminhtml\Directory
 */
class Delete extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Flyxrg_ValidateZipcode::zipcode_delete';

    /**
     * @var ZipcodeFactory
     */
    protected $zipcodeFactory;

    /**
     * @var ZipcodeRepositoryInterface
     */
    protected $zipcodeRepository;

    /**
     * Delete constructor.
     * @param Context $context
     * @param ZipcodeFactory $zipcodeFactory
     * @param ZipcodeRepositoryInterface $zipcodeRepository
     */
    public function __construct(
        Context $context,
        ZipcodeFactory $zipcodeFactory,
        ZipcodeRepositoryInterface $zipcodeRepository
    ) {
        parent::__construct($context);
        $this->zipcodeFactory = $zipcodeFactory;
        $this->zipcodeRepository = $zipcodeRepository;
    }

    /**
     * execute
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        // get ID and prepare object
        $id = $this->getRequest()->getParam('zipcode_id');
        if (!$id) {
            $this->messageManager->addErrorMessage(__('There was an error when processing the request.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }

        try {
            // load the object
            $zipcode = $this->zipcodeRepository->getById($id);
            if (!$zipcode || !$zipcode->getId()) {
                $this->messageManager->addErrorMessage(__('This zipcode no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }

            // delete the object
            $this->zipcodeRepository->delete($zipcode);

            // set success message
            $this->messageManager->addSuccessMessage(__('The zipcode has been successfully deleted.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was an error when preparing the zipcode.'));
            $resultRedirect = $this->resultRedirectFactory->create();
        }
        return $resultRedirect->setPath('*/*/');
    }
}
