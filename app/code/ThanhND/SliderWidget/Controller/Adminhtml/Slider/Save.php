<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/14/2016
 * Time: 9:58 AM
 */

namespace Training\SliderWidget\Controller\Adminhtml\Slider;

use Training\SliderWidget\Controller\Adminhtml\SliderAbstract;

class Save extends SliderAbstract
{
    /**
     * @return void
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            try {
                /** @var \Training\FooterLinks\Model\Link $model */
                $model = $this->_sliderFactory->create();

                $sliderData = $data["general"];
                $sliderId = isset($sliderData["slider_id"]) ? $sliderData["slider_id"]:null;

                // Check the same title
                $slider = $model->load($sliderData['title'],'title')->getData();
                if($slider && !$sliderId)
                {
                    $this->messageManager->addError('This slider already exists.');
                    $this->_redirect('*/*/new', ['_current' => true]);
                    return;
                }

                // Merge form data and db data
                if ($sliderId) {
                    $slider = $model->load($sliderId)->getData();
                    $sliderData = array_merge($slider,$sliderData);
                }

                // Update time
                $updateTime = date('Y-m-d H:i:s');
                if (!isset($sliderData["creation_time"]))
                {
                    $sliderData["creation_time"] = $updateTime;
                }
                $sliderData["update_time"] = $updateTime;

                $model->setData($sliderData);
                $model->save();

                $this->messageManager->addSuccess(__('Slider saved'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the slider'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

}