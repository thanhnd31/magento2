<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/13/2016
 * Time: 2:48 PM
 */

namespace Training\SliderWidget\Controller\Adminhtml\Slider;

use Training\SliderWidget\Controller\Adminhtml\SliderAbstract;

class Edit extends SliderAbstract
{
    /**
     * @return void
     */
    public function execute()
    {
        $sliderId = $this->getRequest()->getParam('id');
        $model = $this->_sliderFactory->create();

        if ($sliderId)
        {
            $model->load($sliderId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This slider no longer exists.'));
                $this->_redirect('*/*/index');
                return;
            }
            $this->_coreRegistry->register('slider_id',$model->getId());
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Training_FooterLinks::training');
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Slider'));

        return $resultPage;
    }
}