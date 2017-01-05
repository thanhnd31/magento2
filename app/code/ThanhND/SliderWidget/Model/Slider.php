<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/13/2016
 * Time: 8:52 AM
 */

namespace ThanhND\SliderWidget\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class Slider extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'sliderwidget_slider';

    protected function _construct()
    {
        $this->_init('ThanhND\SliderWidget\Model\ResourceModel\Slider');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}