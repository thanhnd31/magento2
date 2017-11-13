<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 17/11/2016
 * Time: 15:16
 */

namespace ThanhND\Core\Block\Adminhtml\Edit;


class DeleteButton extends GenericButton
{
    /**
     * Delete button information
     *
     * @return array
     */
    public function getButtonData()
    {
        $itemId = $this->_registry->registry('item_id');
        $onlickAction = '';

        if($itemId)
        {
            $onlickAction = 'deleteConfirm(\'' . __(
                    'Are you sure you want to delete this?'
                ) . '\', \'' . $this->getDeleteUrl($itemId) . '\')';
        }

        $buttonData = [
            'label' => __('Delete'),
            'class' => 'delete',
            'on_click' => $onlickAction,
            'sort_order' => 20,
        ];

        return $buttonData;
    }
}