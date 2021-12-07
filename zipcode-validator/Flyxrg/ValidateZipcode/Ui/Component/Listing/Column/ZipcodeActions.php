<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Ui\Component\Listing\Column;

use Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class ZipcodeActions
 */
class ZipcodeActions extends Column
{
    /**
     * URL_EDIT
     */
    const URL_EDIT = 'zipcode/directory/edit';

    /**
     * URL_DELETE
     */
    const URL_DELETE = 'zipcode/directory/delete';

    /**
     * @var UrlBuilder
     */
    protected $urlBuilder;

    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * ZipcodeActions constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $urlBuilder
     * @param UrlInterface $url
     * @param Escaper $escaper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder $urlBuilder,
        UrlInterface $url,
        Escaper $escaper,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->url = $url;
        $this->escaper = $escaper;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * prepareDataSource
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        // if not items, return
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        // loop every item to build the actions menu
        foreach($dataSource['data']['items'] as & $item) {
            // don't change the name, it's the key for "actions"
            $name = $this->getData('name');
            // build the actions data according with the entity
            if (isset($item['zipcode_id'])) {
                $item[$name]['edit'] = array(
                    'href' => $this->url->getUrl(self::URL_EDIT, ['zipcode_id' => $item['zipcode_id']]),
                    'label' => __('Edit')
                );

                $label = $this->escaper->escapeHtml($item['zipcode']);
                $item[$name]['delete'] = array(
                    'href' => $this->url->getUrl(self::URL_DELETE, ['zipcode_id' => $item['zipcode_id']]),
                    'label' => __('Delete'),
                    'confirm' => array(
                        'title' => __("Delete Zipcode"),
                        'message' => __("Are you sure you want to delete the record <b>%1</b>?", $label)
                    ),
                );
            }
        }
        return $dataSource;
    }
}
