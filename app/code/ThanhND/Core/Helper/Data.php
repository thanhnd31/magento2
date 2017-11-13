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
	/**
	 * @var \Magento\Store\Model\StoreManagerInterface
	 */
    protected $storeManager;

	/**
	 * Data constructor.
	 * @param Context $context
	 * @param \Magento\Store\Model\StoreManagerInterface $storeManager
	 * @param array $data
	 */
    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data=[]
    ){
        parent::__construct($context);

        $this->storeManager = $storeManager;
    }

	/**
	 * @param $path
	 * @param null $storeId
	 * @return mixed
	 */
    public function getConfigValue($path,$storeId = null)
    {
        if(!$storeId)
        {
            $storeId = $this->storeManager->getStore()->getId();
        }

        return $this->scopeConfig->getValue($path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,$storeId);
    }

    public function getWebsite(){
		return $this->storeManager->getWebsite();
	}

	public function getStore(){
    	return $this->storeManager->getStore();
	}
}