<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 17/11/2016
 * Time: 15:11
 */

namespace ThanhND\Core\Block\Adminhtml\Edit;


class SaveButton extends GenericButton
{
    /**
     * Save button information
     *
     * @return array
     */
    public function getButtonData()
    {
        $buttonData = [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];

        return $buttonData;
    }
}