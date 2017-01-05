<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/13/2016
 * Time: 12:06 PM
 */

namespace Training\SliderWidget\Controller\Adminhtml\Slider;

use Training\SliderWidget\Controller\Adminhtml\SliderAbstract;

class Index extends SliderAbstract
{
    /**
     * @return void
     */
    public function execute()
    {
        //Call page factory to render layout and page content
        $resultPage = $this->_resultPageFactory->create();

        //Set the menu which will be active for this page
        $resultPage->setActiveMenu('Training_FooterLinks::training');

        //Set the header title of grid
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Slider'));

        //Add bread crumb
        $resultPage->addBreadcrumb(__('Training'), __('Training'));
        $resultPage->addBreadcrumb(__('Slider'), __('Manage Slider'));

        return $resultPage;
    }
}