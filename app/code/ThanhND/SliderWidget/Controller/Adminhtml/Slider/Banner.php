<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/15/2016
 * Time: 5:16 PM
 */

namespace Training\SliderWidget\Controller\Adminhtml\Slider;


use Training\SliderWidget\Controller\Adminhtml\BannerAbstract;

class Banner extends BannerAbstract
{
    /**
     * @return layout
     */
    public function execute()
    {
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}