<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 24/11/2016
 * Time: 15:39
 */

namespace ThanhND\FooterLink\Controller\Adminhtml\Link;


use ThanhND\FooterLink\Controller\Adminhtml\LinkAbstract;

class InlineEdit extends LinkAbstract
{
    /**
     * Inline Edit execute
     *
     * @return $this
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->_jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        $model = $this->_linkFactory->create();
        foreach (array_keys($postItems) as $linkId) {
            $model->load($linkId);

            if(!$model->getId())
            {
                continue;
            }

            $postData = $postItems[$linkId];
            $linkData = $model->getData();

            $data = array_merge($linkData,$postData);
            $model->setData($data);

            try{
                $model->save();
            } catch (Exception $e)
            {
                $messages =  __('Something went wrong while saving the link.');
                $error = true;
                break;
            }

        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}