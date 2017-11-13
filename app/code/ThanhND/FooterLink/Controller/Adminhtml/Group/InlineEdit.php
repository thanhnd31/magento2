<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 18/11/2016
 * Time: 09:25
 */

namespace ThanhND\FooterLink\Controller\Adminhtml\Group;


use Braintree\Exception;
use ThanhND\FooterLink\Controller\Adminhtml\GroupAbstract;

class InlineEdit extends GroupAbstract
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

        $model = $this->_groupFactory->create();
        foreach (array_keys($postItems) as $groupId) {
            $model->load($groupId);

            if(!$model->getId())
            {
                continue;
            }

            $postData = $postItems[$groupId];
            $groupData = $model->getData();

            $data = array_merge($groupData,$postData);
            $model->setData($data);

            try{
                $model->save();
            } catch (Exception $e)
            {
                $messages =  __('Something went wrong while saving the group.');
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