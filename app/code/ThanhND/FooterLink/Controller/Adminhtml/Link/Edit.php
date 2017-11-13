<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 24/11/2016
 * Time: 15:52
 */

namespace ThanhND\FooterLink\Controller\Adminhtml\Link;

use ThanhND\FooterLink\Controller\Adminhtml\LinkAbstract;

class Edit extends LinkAbstract
{
    /**
     * Edit action execution
     *
     * @return \Magento\Framework\View\Result\Page|void
     */
    public function execute()
    {
        $linkId = $this->getRequest()->getParam('id');

        $model = $this->_linkFactory->create();

        if($linkId)
        {
            $model->load($linkId);
            if(!$model->getId())
            {
                $this->messageManager->addError(__('This link no longer exists.'));
                $this->_redirect('*/*/index');
                return;
            }
            $this->_coreRegistry->register('item_id',$model->getId());
        }

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('ThanhND_Core::thanhnd');
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getLinkName() : __('New Link'));
        return $resultPage;
    }
}