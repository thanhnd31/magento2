<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 18/11/2016
 * Time: 16:31
 */

namespace ThanhND\FooterLink\Controller\Adminhtml\Group;


use ThanhND\FooterLink\Controller\Adminhtml\GroupAbstract;

class Delete extends GroupAbstract
{
    /**
     * Delete group execution
     *
     * @return void
     */
    public function execute()
    {
        $groupId = $this->getRequest()->getParam('id');

        if ($groupId) {
            $model = $this->_groupFactory->create();
            $model->load($groupId);

            if (!$model->getId()) {
                $this->getMessageManager()->addError('This group no longer exists.');
                return;
            }

            try {
                $model->delete();
                $this->getMessageManager()->addSuccess('Delete group success.');
                $this->_redirect('*/*/index');
            } catch (\Exception $e) {
                $this->getMessageManager()->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $model->getId()]);
            }
        }
    }
}