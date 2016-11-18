<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 18/11/2016
 * Time: 17:19
 */

namespace ThanhND\FooterLink\Controller\Adminhtml\Group;


use ThanhND\FooterLink\Controller\Adminhtml\GroupAbstract;

class Onepage extends GroupAbstract
{
    /**
     * @return  void
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('ThanhND_Core::smtraining');
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Footer Link Group'));

        $resultPage->addBreadcrumb(__('Training'),__('Training'));
        $resultPage->addBreadcrumb(__('Manage Link Group'),__('Manage Link Group'));

        return $resultPage;
    }
}