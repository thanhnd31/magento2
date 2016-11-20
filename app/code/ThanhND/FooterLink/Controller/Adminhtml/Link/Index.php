<?php
namespace ThanhND\FooterLink\Controller\Adminhtml\Link;

use ThanhND\FooterLink\Controller\Adminhtml\LinkAbstract;

class Index extends LinkAbstract
{
	/**
     * @return  void
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('ThanhND_Core::smtraining');
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Footer Links'));

        $resultPage->addBreadcrumb(__('Training'),__('Training'));
        $resultPage->addBreadcrumb(__('Manage Links'),__('Manage Links'));

        return $resultPage;
    }
}