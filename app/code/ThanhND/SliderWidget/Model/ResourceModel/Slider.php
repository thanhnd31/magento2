<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/13/2016
 * Time: 8:55 AM
 */

namespace ThanhND\SliderWidget\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Slider extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('sliderwidget_slider','slider_id');
    }
}