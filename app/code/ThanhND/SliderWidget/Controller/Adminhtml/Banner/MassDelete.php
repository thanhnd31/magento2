<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/14/2016
 * Time: 2:24 PM
 */

namespace ThanhND\SliderWidget\Controller\Adminhtml\Banner;

use ThanhND\SliderWidget\Controller\Adminhtml\BannerAbstract;

class MassDelete extends BannerAbstract
{
    /**
     * @return void
     */
    public function execute()
    {
        $bannerIds = $this->getRequest()->getParam('selected');
        if ($bannerIds)
        {
            $model = $this->_bannerFactory->create();
            $success = 0;
            foreach ($bannerIds as $bannerId) {
                $model->load($bannerId);
                if (!$model->getId())
                {
                    $this->getMessageManager()->addError('The banner (id = %1) does not exist.',$bannerId);
                }

                try
                {
                    $model->delete();
                    $success++;
                }
                catch (\Exception $e)
                {
                    $this->messageManager->addError($e->getMessage());
                }
            }

            $total = count($bannerIds);
            if($total)
            {
                $this->getMessageManager()->addSuccess(
                    __('Delete groups: Total: %1, Success: %2, Fail: %3',
                        $total,$success,$total-$success));
            }
        }

        $this->_redirect('*/*/index');
    }
}