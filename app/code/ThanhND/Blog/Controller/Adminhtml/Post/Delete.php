<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 08/08/2017
 * Time: 14:20
 */

namespace ThanhND\Blog\Controller\Adminhtml\Post;


use ThanhND\Blog\Controller\Adminhtml\AbstractPost;

class Delete extends AbstractPost
{
    public function execute()
    {
        $postId = $this->getRequest()->getParam('post_id');
        $model = $this->postFactory->create();
        $resultRedirect = $this->resultRedirectFactory->create();

        $model->load($postId);
        if(!$model->getId())
        {
            $this->messageManager->addError(__('This post no longer exists. We can not find a post to delete'));
            $resultRedirect->setPath('*/*/');
            return $resultRedirect;
        }

        try
        {
            $model->delete();

            $this->messageManager->addSuccess(__('The post has been deleted.'));

            $resultRedirect->setPath('*/*/');
            return $resultRedirect;
        } catch (\Exception $e)
        {
            $this->messageManager->addError($e->getMessage());
            $resultRedirect->setPath('*/*/');
            return $resultRedirect;
        }
    }
}