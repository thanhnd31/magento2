<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 24/11/2016
 * Time: 15:57
 */

namespace ThanhND\FooterLink\Controller\Adminhtml\Link;

use ThanhND\FooterLink\Controller\Adminhtml\LinkAbstract;

class Save extends LinkAbstract
{

    /**
     * Save action execution
     *
     * @return $this
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();

        if($data)
        {
            try{
                $model = $this->_linkFactory->create();

                $postData = $data['general'];
                $linkId = isset($postData['link_id'])?$postData['link_id']:null;

                // Check new link name is existed
                $linkData = $model->load($postData['link_name'],'link_name')->getData();

                if($linkData && !$linkId)
                {
                    $this->messageManager->addError('This link already exists.');
                    $this->_redirect('*/*/new', ['_current' => true]);
                    return;
                }

                // Update link information
                if($linkId)
                {
                    $linkData = $model->load($linkId)->getData();
                    $postData = array_merge($linkData,$postData);
                }

                // Set update time
                $updateTime = date('Y-m-d H:i:s');
                if(!isset($postData['creation_time']))
                {
                    $postData['creation_time'] = $updateTime;
                }
                $postData['update_time'] = $updateTime;

                // Save data to database
                $model->setData($postData);
                $model->save();

                $this->messageManager->addSuccess(__('Link saved'));
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
                $this->messageManager->addException($e, __('Something went wrong while saving the link'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}