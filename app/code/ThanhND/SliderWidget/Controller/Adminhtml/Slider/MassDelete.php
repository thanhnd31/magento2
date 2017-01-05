<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/14/2016
 * Time: 9:55 AM
 */

namespace Training\SliderWidget\Controller\Adminhtml\Slider;

use Training\SliderWidget\Controller\Adminhtml\SliderAbstract;

class MassDelete extends SliderAbstract
{
    /**
     * @return void
     */
    public function execute()
    {
        $sliderIds = $this->getRequest()->getParam('selected');

        if($sliderIds)
        {
            $model = $this->_groupFactory->create();
            $success = 0;
            foreach ($sliderIds as $sliderId) {
                $model->load($sliderId);
                if (!$model->getId())
                {
                    $this->getMessageManager()->addError('The slider (id = %1) does not exist.',$sliderId);
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

            $total = count($sliderIds);
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