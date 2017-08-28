<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 17/11/2016
 * Time: 14:17
 */

namespace ThanhND\FooterLink\Controller\Adminhtml\Group;

use ThanhND\FooterLink\Controller\Adminhtml\GroupAbstract;

class Edit extends GroupAbstract
{
    /**
     * Edit action execution
     *
     * @return \Magento\Framework\View\Result\Page|void
     */
    public function execute()
    {
        $groupId = $this->getRequest()->getParam('id');

        $model = $this->_groupFactory->create();

        if($groupId)
        {
            $model->load($groupId);
            if(!$model->getId())
            {
                $this->messageManager->addError(__('This group no longer exists.'));
                $this->_redirect('*/*/index');
                return;
            }
            $this->_coreRegistry->register('item_id',$model->getId());
        }

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('ThanhND_Core::thanhnd');
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getGroupName() : __('New Group'));
        return $resultPage;
    }
}