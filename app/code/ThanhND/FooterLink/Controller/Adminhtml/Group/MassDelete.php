<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 18/11/2016
 * Time: 16:32
 */

namespace ThanhND\FooterLink\Controller\Adminhtml\Group;

use ThanhND\FooterLink\Controller\Adminhtml\GroupAbstract;

class MassDelete extends GroupAbstract
{
    /**
     * Mass action delete execution
     * @return void
     */
    public function execute()
    {
        $groupIds = $this->getRequest()->getParam('selected');

        if($groupIds)
        {
            $model = $this->_groupFactory->create();
            $success = 0;
            foreach ($groupIds as $groupId) {
                $model->load($groupId);
                if (!$model->getId())
                {
                    $this->getMessageManager()->addError('The group (id = %1) does not exist.',$groupId);
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

            $total = count($groupIds);
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