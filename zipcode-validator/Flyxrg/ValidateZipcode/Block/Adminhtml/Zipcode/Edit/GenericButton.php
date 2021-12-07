<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Block\Adminhtml\Zipcode\Edit;

use Flyxrg\ValidateZipcode\Api\ZipcodeRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Psr\Log\LoggerInterface;

/**
 * Class GenericButton
 *
 * Gugliotti News Backend Buttons.
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Flyxrg\ValidateZipcode\Block\Adminhtml\Zipcode\Edit\GenericButton
 * @see \Magento\Cms\Block\Adminhtml\Page\Edit\GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var ZipcodeRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * GenericButton constructor.
     * @param Context $context
     * @param ZipcodeRepositoryInterface $categoryRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        ZipcodeRepositoryInterface $categoryRepository,
        LoggerInterface $logger
    ) {
        $this->context = $context;
        $this->categoryRepository = $categoryRepository;
        $this->logger = $logger;
    }

    /**
     * getZipcodeId
     * @return int|null
     */
    public function getZipcodeId()
    {
        try {
            return $this->categoryRepository->getById(
                $this->context->getRequest()->getParam('zipcode_id')
            )->getId();
        } catch (\Exception $e) {
            $this->logger->critical($e);
        }
        return null;
    }

    /**
     * getUrl
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
