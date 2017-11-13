<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 24/11/2016
 * Time: 15:55
 */

namespace ThanhND\FooterLink\Controller\Adminhtml\Link;


use ThanhND\FooterLink\Controller\Adminhtml\LinkAbstract;

class Delete extends LinkAbstract
{
    /**
     * Delete action execution
     *
     * @return  void
     */
    public function execute()
    {
        $linkId = $this->getRequest()->getParam('id');

        if ($linkId) {
            $model = $this->_linkFactory->create();
            $model->load($linkId);

            if (!$model->getId()) {
                $this->getMessageManager()->addError('This link no longer exists.');
                return;
            }

            try {
                $model->delete();
                $this->getMessageManager()->addSuccess('Delete link success.');
                $this->_redirect('*/*/index');
            } catch (\Exception $e) {
                $this->getMessageManager()->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $model->getId()]);
            }
        }
    }
}