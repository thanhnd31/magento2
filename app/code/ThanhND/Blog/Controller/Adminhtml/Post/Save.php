<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 08/08/2017
 * Time: 16:25
 */

namespace ThanhND\Blog\Controller\Adminhtml\Post;


use Magento\Framework\Exception\LocalizedException;
use ThanhND\Blog\Controller\Adminhtml\AbstractPost;

class Save extends AbstractPost
{
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }

        $postId = $this->getRequest()->getParam('post_id');
        $model = $this->postFactory->create();
        if ($postId) {
            $model->load($postId);
        }

        $model->setData($data);

        $this->_eventManager->dispatch(
            'blog_post_prepare_save',
            ['post' => $model, 'request' => $this->getRequest()]
        );

        try {
            $model->save();

            $this->messageManager->addSuccess(__('This post is saved successful'));
            $this->_session->setFormData(false);
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $model->getId(), '_current' => true]);
            }
            return $resultRedirect->setPath('*/*/');
        } catch (LocalizedException $e){
            $this->messageManager->addError($e->getMessage());
        } catch (\RuntimeException $e){
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Something went wrong while save post.'));
        }

        $this->_getSession()->setFormData($data);
        return $resultRedirect->setPath('*/*/edit',['post_id'=>$this->getRequest()->getParam('post_id')]);
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('ThanhND_Blog::save');
    }
}