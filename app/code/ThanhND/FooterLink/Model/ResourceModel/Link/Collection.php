<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 07/11/2016
 * Time: 16:51
 */

namespace ThanhND\FooterLink\Model\ResourceModel\Link;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Collection initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ThanhND\FooterLink\Model\Link','ThanhND\FooterLink\Model\ResourceModel\Link');
    }
}