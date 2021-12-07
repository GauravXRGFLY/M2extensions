<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Controller\Adminhtml\Directory;

use Flyxrg\ValidateZipcode\Api\ZipcodeRepositoryInterface;
use Flyxrg\ValidateZipcode\Model\Zipcode;
use Flyxrg\ValidateZipcode\Model\ZipcodeFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;

/**
 * Class Save
 *
 * Backend Zipcode Save Controller.
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Flyxrg\ValidateZipcode\Controller\Adminhtml\Directory
 */
class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Flyxrg_ValidateZipcode::zipcode_save';

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var ZipcodeFactory
     */
    protected $zipcodeFactory;

    /**
     * @var ZipcodeRepositoryInterface
     */
    protected $zipcodeRepository;
	
	/**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * Save constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param ZipcodeFactory $zipcodeFactory
     * @param ZipcodeRepositoryInterface $zipcodeRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        ZipcodeFactory $zipcodeFactory,
        ZipcodeRepositoryInterface $zipcodeRepository
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->dataPersistor = $dataPersistor;
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
        $data = $this->getRequest()->getParams();

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
            } else {
                $data['zipcode_id'] = null;
                $zipcode = $this->zipcodeFactory->create();
            }

            $zipcode->setData($data)->save();
            $this->dataPersistor->clear('zipcode_directory');

            // set success message
            $this->messageManager->addSuccessMessage(__('The zipcode has been successfully saved.'));

            // if Save and Continue
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['zipcode_id' => $zipcode->getId(), '_current' => true]);
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was an error when preparing the zipcode.'));
            $resultRedirect = $this->resultRedirectFactory->create();
        }
        return $resultRedirect->setPath('*/*/');
    }
}
