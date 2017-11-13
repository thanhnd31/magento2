<?php

namespace ThanhND\Blog\Controller\Adminhtml\Post;

use ThanhND\Blog\Controller\Adminhtml\AbstractPost;

class Index extends AbstractPost
{
    
    const ADMIN_RESOURCE = 'Index';
    
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('ThanhND_Blog::post');
        $resultPage->addBreadcrumb(__('Blog Posts'), __('Blog Posts'));
        $resultPage->addBreadcrumb(__('Manage Post'), __('Manage Post'));
        $resultPage->getConfig()->getTitle()->prepend(__('Blog Posts'));

        return $resultPage;
    }
}
