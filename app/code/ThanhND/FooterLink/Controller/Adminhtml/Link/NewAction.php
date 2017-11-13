<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 24/11/2016
 * Time: 15:51
 */

namespace ThanhND\FooterLink\Controller\Adminhtml\Link;


use ThanhND\FooterLink\Controller\Adminhtml\LinkAbstract;

class NewAction extends LinkAbstract
{
    /**
     * @return forward edit action
     */
    public function execute()
    {
        return $this->_forward('edit');
    }
}