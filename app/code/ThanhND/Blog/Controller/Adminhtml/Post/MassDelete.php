<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 07/08/2017
 * Time: 16:28
 */

namespace ThanhND\Blog\Controller\Adminhtml\Post;

use Magento\Framework\Controller\ResultFactory;
use ThanhND\Blog\Controller\Adminhtml\AbstractPostMassActions;

class MassDelete extends AbstractPostMassActions
{
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach($collection as $item)
        {
            $item->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.',$collectionSize));

        $resultRedirect = $this->resultFactory->create(self::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}