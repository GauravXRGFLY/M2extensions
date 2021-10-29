<?php
/**
 * Flyxrg Preview product and category Plugin
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * It is available on the World Wide Web at:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Flyxrg Preview product and category Plugin
 * @package    Flyxrg_Preview
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Flyxrg\Preview\Block\Adminhtml\Category\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Catalog\Block\Adminhtml\Category\AbstractCategory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class PreviewButton
 */
class PreviewButton extends AbstractCategory implements ButtonProviderInterface
{
	/**
     * @var \Magento\Framework\Url
     */
    protected $_url;

	/**
     * @var dataHelper
     */
    protected $dataHelper;
	
	/** @var _storeManager */
	protected $_storeManager;
	
	/**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Url $url
	 * @param \Flyxrg\Preview\Helper\Data $dataHelper
	 * @param \Magento\Framework\Registry $registry
	 * @param StoreManagerInterface $storeManager
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
		\Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\Tree $categoryTree,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Framework\Url $url,
		\Flyxrg\Preview\Helper\Data $dataHelper,
		StoreManagerInterface $storeManager,
		array $data = []
    ) {
        $this->_url = $url;
		$this->dataHelper = $dataHelper;
		$this->_storeManager = $storeManager;
		parent::__construct($context,$categoryTree,$registry,$categoryFactory,$data);
    }

    /**
     * Delete button
     *
     * @return array
     */
    public function getButtonData()
    {
		if ($this->dataHelper->allowExtension() && $this->dataHelper->getGeneralConfig("preview_categories"))
		{
			$category = $this->_coreRegistry->registry('category');
			$categoryId = (int)$category->getId();

			if ($categoryId && !in_array($categoryId, $this->getRootIds()) && $category->isDeleteable()) {
				return [
					'id' => 'preview',
					'label' => __('Preview'),
					'on_click' 	=> 'window.open(\'' . $this->getPreviewUrl() . '\')',
					'class' => 'action- scalable',
					'sort_order' => 15
				];
			}
		}
        return [];
    }

    /**
     * @param array $args
     * @return string
     */
    public function getPreviewUrl(array $args = [])
    {
		$category 	= $this->_coreRegistry->registry('category');
        $categoryId = (int)$category->getId();
		$storeId = $this->_storeManager->getDefaultStoreView()->getStoreId();
		
		return $this->_url->getUrl('catalog/category/view', ['id' => $categoryId, '_nosid' => false, '_query' => ['___store' => $storeId]]);
    }
}