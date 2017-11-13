<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 18/11/2016
 * Time: 17:30
 */

namespace ThanhND\Core\Block\Adminhtml;

use Magento\Backend\Block\Widget\Container;

class Onepage extends Container
{
    protected $_template = 'ThanhND_Core::onepage.phtml';

    public function welcome()
    {
        return __('Welcome to admin one page.');
    }
}