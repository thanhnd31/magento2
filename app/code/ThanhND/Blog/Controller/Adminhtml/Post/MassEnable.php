<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 07/08/2017
 * Time: 16:39
 */

namespace ThanhND\Blog\Controller\Adminhtml\Post;

use ThanhND\Blog\Controller\Adminhtml\AbstractPostMassActions;

class MassEnable extends AbstractPostMassActions
{
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach($collection as $item)
        {
            $item->setIsActive(true);
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been enabled.',$collection->getSize()));
        $resultRedirect = $this->resultFactory->create(self::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/');
    }
}