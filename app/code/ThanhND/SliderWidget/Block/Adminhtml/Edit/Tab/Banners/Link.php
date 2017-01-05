<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 21/09/2016
 * Time: 14:26
 */

namespace ThanhND\SliderWidget\Block\Adminhtml\Edit\Tab\Banners;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Framework\DataObject;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Backend\Block\Context;

class Link extends AbstractRenderer
{
    private $_storeManager;
    /**
     * @param \Magento\Backend\Block\Context $context
     * @param array $data
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storemanager,
        array $data = [])
    {
        $this->_storeManager = $storemanager;
        parent::__construct($context, $data);
        $this->_authorization = $context->getAuthorization();

    }
    /**
     * Renders grid column
     *
     * @param Object $row
     * @return  string
     */
    public function render(DataObject $row)
    {
        return '<a href="'.$this->_getValue($row).'">'.$this->_getValue($row).'</a>';
    }
}