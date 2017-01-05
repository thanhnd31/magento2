<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/13/2016
 * Time: 2:46 PM
 */

namespace Training\SliderWidget\Controller\Adminhtml\Slider;

use Training\SliderWidget\Controller\Adminhtml\SliderAbstract;

class NewAction extends SliderAbstract
{
    /**
     * @return forward edit action
     */
    public function execute()
    {
        return $this->_forward('edit');
    }
}