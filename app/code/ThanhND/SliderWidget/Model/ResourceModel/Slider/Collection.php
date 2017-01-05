<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/13/2016
 * Time: 8:59 AM
 */

namespace ThanhND\SliderWidget\Model\ResourceModel\Slider;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('ThanhND/SliderWidget/Model/Slider','ThanhND/SliderWidget/Model/ResourceModel/Slider');
    }
}