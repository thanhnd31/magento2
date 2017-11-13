<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 17/11/2016
 * Time: 15:05
 */

namespace ThanhND\Core\Block\Adminhtml\Edit;


class BackButton extends GenericButton
{
    /**
     * Back button information
     *
     * @return array
     */
    public function getButtonData()
    {
        $butonData = [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];

        return $butonData;
    }
}