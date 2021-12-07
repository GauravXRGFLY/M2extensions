<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Controller\Adminhtml\Directory;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 *
 * Backend Category Index Controller.
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Flyxrg\ValidateZipcode\Controller\Adminhtml\Directory
 */
class Index extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Flyxrg_ValidateZipcode::zipcode_index';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * execute
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Zipcode_Backend::menu');
        $resultPage->addBreadcrumb(__('Zipcode'), __('Zipcode Services'));
        $resultPage->addBreadcrumb(__('Zipcode Services'), __('Zipcode Services'));
        $resultPage->addBreadcrumb(__('Manage Zipcode Services'), __('Manage Zipcode Services'));
        $resultPage->getConfig()->getTitle()->prepend(__('Zipcode Services'));

        return $resultPage;
    }
}
