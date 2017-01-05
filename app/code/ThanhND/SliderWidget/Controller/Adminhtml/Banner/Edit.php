<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/14/2016
 * Time: 2:30 PM
 */

namespace ThanhND\SliderWidget\Controller\Adminhtml\Banner;

use ThanhND\SliderWidget\Controller\Adminhtml\BannerAbstract;

class Edit extends BannerAbstract
{
    /**
     * @return void
     */
    public function execute()
    {
        $bannerId = $this->getRequest()->getParam('id');
        $model = $this->_bannerFactory->create();

        if ($bannerId)
        {
            $model->load($bannerId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This banner no longer exists.'));
                $this->_redirect('*/*/index');
                return;
            }
            $this->_coreRegistry->register('banner_id',$model->getId());
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('ThanhND_Core::smtraining');
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Banner'));

        return $resultPage;
    }
}