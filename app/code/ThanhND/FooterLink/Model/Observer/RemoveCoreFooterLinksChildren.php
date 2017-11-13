<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 08/11/2016
 * Time: 11:24
 */

namespace ThanhND\FooterLink\Model\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class RemoveCoreFooterLinksChildren implements ObserverInterface
{
    /** @var  ScopeConfigInterface */
    protected $_scopeConfig;

    /**
     * RemoveCoreFooterLinksChildren constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     *
     * @return void
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * Remove all core footer link children event action
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $block = $observer->getBlock();
        if('footer_links' == $block->getNameInLayout())
        {
            $isEnable = $this->_scopeConfig->getValue(
                'thanhnd_footerlink/general/enable',
                ScopeInterface::SCOPE_STORE
            );

            if ($isEnable)
            {
                $block->unsetChildren();
            }
        }
    }
}