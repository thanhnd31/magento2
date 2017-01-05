<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/14/2016
 * Time: 2:16 PM
 */

namespace ThanhND\SliderWidget\Controller\Adminhtml\Banner;

use ThanhND\SliderWidget\Controller\Adminhtml\BannerAbstract;

class Delete extends BannerAbstract
{
    /**
     * @return void
     */
    public function execute()
    {
        $bannerId = $this->getRequest()->getParam('id');
        if($bannerId) {
            $model = $this->_bannerFactory->create();
            $model->load($bannerId);

            if (!$model->getId()) {
                $this->getMessageManager()->addError('This banner no longer exists.');
                return;
            }

            try {
                $model->delete();
                $this->getMessageManager()->addSuccess('Delete banner success.');
                $this->_redirect('*/*/index');
            } catch (\Exception $e)
            {
                $this->getMessageManager()->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $model->getId()]);
            }
        }
    }

}