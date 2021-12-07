<?php
declare(strict_types=1);
namespace Flyxrg\ValidateZipcode\Block\Adminhtml\Zipcode\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 *
 * Gugliotti News Backend Buttons.
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Flyxrg\ValidateZipcode\Block\Adminhtml\Zipcode\Edit\SaveButton
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * getButtonData
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Zipcode'),
            'class' => 'save primary',
            'data-attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save'
            ],
            'sort_order' => 90
        ];
    }
}
