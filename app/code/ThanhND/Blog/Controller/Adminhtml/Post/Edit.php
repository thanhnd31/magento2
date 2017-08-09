<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 08/08/2017
 * Time: 11:39
 */

namespace ThanhND\Blog\Controller\Adminhtml\Post;

use ThanhND\Blog\Controller\Adminhtml\AbstractPost;

class Edit extends AbstractPost
{
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('ThanhND::post')
            ->addBreadcrumb(__('Blog'),__('Blog'))
            ->AddBreadcrumb(__('Manage Post'),__('Manage Post'));

        return $resultPage;
    }

    public function execute()
    {
        $postId = $this->getRequest()->getParam('post_id');
        $model = $this->postFactory->create();

        $model->load($postId);
        if(!$model->getId())
        {
            $this->messageManager->addError(__('This post no longer exists'));
            $resultRedirect = $this->resultRedirectFactory->create();

            return $resultRedirect->setPath('*/*/');
        }

        $data = $this->_session->getFormData(true);
        $model->setData($data);

        $this->_coreRegistry->register('blog_post',$model);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('ThanhND::post')
            ->addBreadcrumb(__('Edit Blog Post'),__('Edit Blog Post'))
            ->addBreadcrumb(__('Edit Blog Post'),__('Edit Blog Post'));

        $resultPage->getConfig()->getTitle()->prepend(__('Blog Posts'));
        $resultPage->getConfig()->getTitle()->prepend($model->getTitle());

        return $resultPage;
    }
}