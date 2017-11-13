<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 07/11/2016
 * Time: 16:49
 */

namespace ThanhND\FooterLink\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Link extends AbstractDb
{
    /**
     * Resource model initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('thanhnd_footerlink_link','link_id');
    }
}