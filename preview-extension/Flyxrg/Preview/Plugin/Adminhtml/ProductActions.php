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

/**
 * Preview button
 */
namespace Flyxrg\Preview\Plugin\Adminhtml;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\UrlInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder;
use Magento\Store\Model\StoreManagerInterface;

class ProductActions
{
	/**
     * @var UrlInterface
     */
    protected $urlBuilder;
	
	/**
     * @var context
     */
    protected $context;
	
	/**
     * @var dataHelper
     */
    protected $dataHelper;
	
	/**
     * @var productFactory
     */
    protected $_product;
	
	/**
     * @var \Magento\Framework\Url
     */
    protected $_url;
	
	/** @var UrlBuilder */
    protected $actionUrlBuilder;
	
	/** @var _storeManager */
	protected $_storeManager;
	
	/**
     * @param ContextInterface $context
     * @param UrlInterface $urlBuilder
	 * @param \Flyxrg\Preview\Helper\Data $dataHelper
	 * @param ProductFactory $productFactory
     * @param \Magento\Framework\Url $url
	 * @param UrlBuilder $actionUrlBuilder
	 * @param StoreManagerInterface $storeManager
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
		ContextInterface $context,
		UrlInterface $urlBuilder,
		\Flyxrg\Preview\Helper\Data $dataHelper,
		ProductFactory $productFactory,
		\Magento\Framework\Url $url,
		UrlBuilder $actionUrlBuilder,
		StoreManagerInterface $storeManager
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->context = $context;
        $this->dataHelper = $dataHelper;
		$this->_product	= $productFactory;
		$this->_url = $url;
		$this->actionUrlBuilder = $actionUrlBuilder;
		$this->_storeManager = $storeManager;
    }
	
	/**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function afterPrepareDataSource($productActions, $result) 
	{
        if ($this->dataHelper->allowExtension() && $this->dataHelper->getGeneralConfig("preview_product"))
		{
            if (isset($result['data']['items'])) 
			{
               $storeId = $this->context->getFilterParam('store_id');
               foreach ($result['data']['items'] as &$item)
			   {
				   if($this->checkPreviewAllow($item['entity_id']))
				   {
					    $storeId = $this->_storeManager->getDefaultStoreView()->getStoreId();
						$previewURL = $this->_url->getUrl('catalog/product/view', ['id' => $item['entity_id'], '_nosid' => false, '_query' => ['___store' => $storeId]]);

						$item[$productActions->getData('name')]['preview'] = [
							'href' => $this->actionUrlBuilder->getUrl(
                                $previewURL, isset($item['_first_store_id']) ? $item['_first_store_id'] : null, isset($item['store_code']) ? $item['store_code'] : null
							),
							'label' => __('Preview'),
							'hidden' => false,
							'target' => "_blank"
						];
				   }
				}
            }
        }
        return $result;
    }
	
	/**
     * @var bool
     */
	public function checkPreviewAllow($productId)
	{
		$product = $this->_product->create()->load($productId);
		if($product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility() && ($product->getStatus() == 1))
		{
			return true;
		}
	}
}