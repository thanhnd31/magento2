<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 29/08/2017
 * Time: 10:05
 */

namespace ThanhND\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    protected $storeManager;

    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data=[]
    ){
        parent::__construct($context);

        $this->storeManager = $storeManager;
    }

    public function getConfigValue($path,$storeId = null)
    {
        if(!$storeId)
        {
            $storeId = $this->storeManager->getStore()->getId();
        }

        return $this->scopeConfig->getValue($path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,$storeId);
    }
}