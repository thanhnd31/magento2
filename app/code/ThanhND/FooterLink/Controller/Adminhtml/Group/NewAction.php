<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 17/11/2016
 * Time: 16:24
 */

namespace ThanhND\FooterLink\Controller\Adminhtml\Group;

use ThanhND\FooterLink\Controller\Adminhtml\GroupAbstract;

class NewAction extends GroupAbstract
{
    /**
     * @return forward edit action
     */
    public function execute()
    {
        return $this->_forward('edit');
    }
}