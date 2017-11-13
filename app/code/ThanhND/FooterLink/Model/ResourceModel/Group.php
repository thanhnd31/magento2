<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 07/11/2016
 * Time: 16:30
 */

namespace ThanhND\FooterLink\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Group extends AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('thanhnd_footerlink_group','group_id');
    }
}