<?php

namespace ThanhND\Blog\Block;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use ThanhND\Blog\Api\Data\PostInterface;
use ThanhND\Blog\Model\ResourceModel\Post\Collection as PostCollection;

class Post extends \Magento\Framework\View\Element\Template implements IdentityInterface
{
    protected $_postCollection;

    public function __construct(
        Template\Context $context,
        \ThanhND\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->_postCollection = $postCollectionFactory;
    }


    public function getPosts()
    {
        $postCollection = $this->_postCollection->create();
        $postCollection->addFilter('is_active', 1)
            ->addOrder(PostInterface::CREATION_TIME, PostCollection::SORT_ORDER_DESC);

        return $postCollection;
    }


    public function getIdentities()
    {
        return [\ThanhND\Blog\Model\Post::CACHE_TAG . '_' . 'list'];
    }

}
