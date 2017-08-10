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
        $id = $this->getRequest()->getParam('post_id');
        $model = $this->postFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This post no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('blog_post',$model);

        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Blog Post') : __('New Blog Post'),
            $id ? __('Edit Blog Post') : __('New Blog Post')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Blog Posts'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Blog Post'));

        return $resultPage;
    }
}