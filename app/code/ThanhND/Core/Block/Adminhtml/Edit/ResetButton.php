<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 17/11/2016
 * Time: 15:07
 */

namespace ThanhND\Core\Block\Adminhtml\Edit;


class ResetButton extends GenericButton
{
    /**
    * Reset button information
    *
    * @return array
    */
    public function getButtonData()
    {
        $butonData = [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30
        ];

        return $butonData;
    }
}