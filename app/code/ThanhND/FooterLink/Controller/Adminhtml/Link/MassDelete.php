<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 24/11/2016
 * Time: 15:56
 */

namespace ThanhND\FooterLink\Controller\Adminhtml\Link;

use ThanhND\FooterLink\Controller\Adminhtml\LinkAbstract;

class MassDelete extends LinkAbstract
{
    /**
     * Mass action delete execution
     * @return void
     */
    public function execute()
    {
        $linkIds = $this->getRequest()->getParam('selected');

        if($linkIds)
        {
            $model = $this->_linkFactory->create();
            $success = 0;
            foreach ($linkIds as $linkId) {
                $model->load($linkId);
                if (!$model->getId())
                {
                    $this->getMessageManager()->addError('The link (id = %1) does not exist.',$linkId);
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

            $total = count($linkIds);
            if($total)
            {
                $this->getMessageManager()->addSuccess(
                    __('Delete links: Total: %1, Success: %2, Fail: %3',
                        $total,$success,$total-$success));
            }
        }

        $this->_redirect('*/*/index');
    }
}