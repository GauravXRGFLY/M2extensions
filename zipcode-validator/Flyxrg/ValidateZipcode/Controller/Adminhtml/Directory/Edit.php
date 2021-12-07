<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Controller\Adminhtml\Directory;

use Flyxrg\ValidateZipcode\Api\ZipcodeRepositoryInterface;
use Flyxrg\ValidateZipcode\Model\ZipcodeFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit
 */
class Edit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Flyxrg_ValidateZipcode::zipcode_edit';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var ZipcodeFactory
     */
    protected $zipcodeFactory;

    /**
     * @var ZipcodeRepositoryInterface
     */
    protected $zipcodeRepository;

    /**
     * Edit constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $coreRegistry
     * @param ZipcodeFactory $zipcodeFactory
     * @param ZipcodeRepositoryInterface $zipcodeRepository
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        ZipcodeFactory $zipcodeFactory,
        ZipcodeRepositoryInterface $zipcodeRepository
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->zipcodeFactory = $zipcodeFactory;
        $this->zipcodeRepository = $zipcodeRepository;
    }

    /**
     * execute
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Flyxrg_ValidateZipcode::menu');
        $resultPage->addBreadcrumb(__('FAQ'), __('FAQ'));
        $resultPage->addBreadcrumb(__('Zipcode'), __('Zipcode'));
        $resultPage->getConfig()->getTitle()->prepend(__('Zipcode'));

        // get ID and prepare object
        $id = $this->getRequest()->getParam('zipcode_id');
        try {
            if ($id) {
                // load the object
                $zipcode = $this->zipcodeRepository->getById($id);
                if (!$zipcode || !$zipcode->getId()) {
                    $this->messageManager->addErrorMessage(__('This zipcode no longer exists.'));
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
                $resultPage->addBreadcrumb(__('Edit Zipcode'), __('Edit Zipcode'));
            } else {
                $zipcode = $this->zipcodeFactory->create();
                $resultPage->addBreadcrumb(__('Add Zipcode'), __('Add Zipcode'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was an error when preparing the zipcode.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }

        $this->coreRegistry->register('zipcode_directory', $zipcode);
        return $resultPage;
    }
}
