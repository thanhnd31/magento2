<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 08/08/2017
 * Time: 11:16
 */

namespace ThanhND\Blog\Controller\Adminhtml\Post;

use ThanhND\Blog\Controller\Adminhtml\AbstractPost;

class NewAction extends AbstractPost
{
    public function execute()
    {
//        $resultForward = $this->resultForwardFactory->create();
//        return $resultForward->forward('edit');
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('ThanhND_Core::smtraining');
        $resultPage->getConfig()->getTitle()
            ->prepend( __('New Group'));
        return $resultPage;
    }
}