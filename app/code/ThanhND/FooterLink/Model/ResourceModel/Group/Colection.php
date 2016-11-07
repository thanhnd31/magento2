<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 07/11/2016
 * Time: 16:33
 */

namespace ThanhND\FooterLink\Model\ResourceModel\Group;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Colection extends AbstractCollection
{
    /**
     * Collection initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ThanhND\FooterLink\Model\Group','ThanhND\FooterLink\Model\ResourceModel\Group');
    }
}