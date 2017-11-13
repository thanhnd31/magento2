<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 18/11/2016
 * Time: 15:46
 */

namespace ThanhND\FooterLink\Controller\Adminhtml\Group;


use ThanhND\FooterLink\Controller\Adminhtml\GroupAbstract;

class Save extends GroupAbstract
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
                $model = $this->_groupFactory->create();

                $postData = $data['general'];
                $groupId = isset($postData['group_id'])?$postData['group_id']:null;

                // Check new group name is existed
                $groupData = $model->load($postData['group_name'],'group_name')->getData();

                if($groupData && !$groupId)
                {
                    $this->messageManager->addError('This group already exists.');
                    $this->_redirect('*/*/new', ['_current' => true]);
                    return;
                }

                // Update group information
                if($groupId)
                {
                    $groupData = $model->load($groupId)->getData();
                    $postData = array_merge($groupData,$postData);
                }

                // Set update time
                $updateTime = date('Y-m-d H:i:s');
                if(!isset($postData['creation_time']))
                {
                    $postData['creation_time'] = $updateTime;
                }
                $postData['update_time'] = $updateTime;

                $postData['store_ids'] = implode(',',$postData['store_ids']);

                // Save data to database
                $model->setData($postData);
                $model->save();

                $this->messageManager->addSuccess(__('Group saved'));
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
                $this->messageManager->addException($e, __('Something went wrong while saving the group'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}