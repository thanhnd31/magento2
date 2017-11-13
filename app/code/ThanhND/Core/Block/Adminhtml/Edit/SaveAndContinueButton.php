<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 17/11/2016
 * Time: 15:12
 */

namespace ThanhND\Core\Block\Adminhtml\Edit;


class SaveAndContinueButton extends GenericButton
{
    /**
     * Save and Continue button information
     *
     * @return array
     */
    public function getButtonData()
    {
        $buttonData = [
            'label' => __('Save and Continue'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => [
                    'button' => ['event' => 'saveAndContinueEdit'],
                ],
            ],
            'sort_order' => 80,
        ];

        return $buttonData;
    }
}