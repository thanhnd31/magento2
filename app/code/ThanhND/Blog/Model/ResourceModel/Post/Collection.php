<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 18/07/2017
 * Time: 10:03
 */

namespace ThanhND\Blog\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'post_id';

    protected function _construct()
    {
        $this->_init('ThanhND\Blog\Model\Post','ThanhND\Blog\Model\ResourceModel\Post');
    }
}