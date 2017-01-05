<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/13/2016
 * Time: 4:52 PM
 */

namespace Training\SliderWidget\Controller\Adminhtml\Slider;

use Training\SliderWidget\Controller\Adminhtml\SliderAbstract;

class Delete extends SliderAbstract
{
    /**
     * @return void
     */
    public function execute()
    {
        $sliderId = $this->getRequest()->getParam('id');

        if ($sliderId) {
            $model = $this->_sliderFactory->create();
            $model->load($sliderId);
            if (!$model->getId()) {
                $this->getMessageManager()->addError('This group no longer exists.');
                return;
            }

            try {
                $model->delete();
                $this->getMessageManager()->addSuccess('Delete slider success.');
                $this->_redirect('*/*/index');
            } catch (\Exception $e) {
                $this->getMessageManager()->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $model->getId()]);
            }
        }
    }
}