<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/12/2016
 * Time: 11:22 AM
 */

namespace ThanhND\SliderWidget\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;
use ThanhND\SliderWidget\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Slider extends Template implements BlockInterface
{
    protected $_collectionFactory;
    protected $_scopeConfig;

    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        ScopeConfigInterface $scopeConfig,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->_collectionFactory = $collectionFactory;
        $this->_scopeConfig = $scopeConfig;
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('widget/slider.phtml');
    }

    public function getBanners($sliderId)
    {
        $collection = $this->_collectionFactory->create();
        $banners = $collection
            ->addFieldToFilter('status',1)
            ->addFieldToFilter('slider_id',$sliderId)
            ->setOrder('sort_order','asc')
            ->getData();
        return $banners;
    }

    public function getBaseUrl()
    {
        return parent::getBaseUrl();
    }

    public function canShowInFrontEnd()
    {
        $isEnabled = $this->_scopeConfig->getValue(
            'sliderwidget/general/enable_in_frontend',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if($isEnabled)
        {
            return true;
        }
        return false;
    }
}