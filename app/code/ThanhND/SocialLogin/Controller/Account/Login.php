<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 29/09/2017
 * Time: 11:13
 */

namespace ThanhND\SocialLogin\Controller\Account;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use ThanhND\SocialLogin\Model\SocialLogin;
use ThanhND\SocialLogin\Helper\Data as SocialHelper;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Model\Account\Redirect as AccountRedirect;

class Login extends Action
{
	/**
	 * @var SocialLogin
	 */
	protected $social;

	/**
	 * @var SocialHelper
	 */
	protected $socialHelper;

	/**
	 * @var CustomerSession
	 */
	protected $customerSession;

	/**
	 * @var \Magento\Framework\UrlInterface
	 */
	protected $urlBuilder;

	/**
	 * @type
	 */
	private $cookieMetadataManager;

	/**
	 * @type
	 */
	private $cookieMetadataFactory;

	/**
	 * @var AccountRedirect
	 */
	protected $accountRedirect;

	/**
	 * Login constructor.
	 * @param Context $context
	 * @param SocialHelper $socialHelper
	 * @param CustomerSession $customerSession
	 * @param AccountRedirect $accountRedirect
	 * @param SocialLogin $social
	 */
	public function __construct(
		Context $context,
		SocialHelper $socialHelper,
		CustomerSession $customerSession,
		AccountRedirect $accountRedirect,
		SocialLogin $social
	){
		$this->social = $social;
		$this->socialHelper = $socialHelper;
		$this->customerSession = $customerSession;
		$this->urlBuilder = $context->getUrl();
		$this->accountRedirect = $accountRedirect;

		parent::__construct($context);
	}

	/**
	 * @return $this|mixed
	 */
	public function execute()
	{
		$social = $this->getRequest()->getParam('app');

		// Check social type is valid
		if(!$this->socialHelper->isAvailableSocial($social)){
			return $this->closePopup();
		}

		// Get social information
		$userProfile = $this->social->getUserProfile($social);
		if(!$userProfile->identifier){
			$message = __('Email is Null, Please enter email in your %1 profile', $social);
			$this->messageManager->addErrorMessage($message);
			$this->_redirect('customer/account/login');

			return $this;
		}

		// Get social customer
		$customer = $this->social->getCustomer($userProfile->identifier,$social);
		// If new customer, create customer from social information
		if(!$customer->getId()){
			$user = array(
				'lastname'=>$userProfile->lastName,
				'firstname'=>$userProfile->firstName,
				'email'=>$userProfile->email? $userProfile->email: $userProfile->identifier.'@'.strtolower($social).'.com',
				'identifier'=>$userProfile->identifier,
				'social'=>$social
			);
			try{
				$customer = $this->social->createCustomer($user,$this->socialHelper->getStore());
			}catch (\Excepttion $e){
				$this->messageManager->addErrorMessage($e->getMessage());
				$this->_redirect('customer/account/login');
				return $this;
			}
		}
		return $this->loginRedirect($customer);
	}

	/**
	 * @param $customer
	 * @return mixed
	 */
	protected function loginRedirect($customer){
		if($customer || $customer->getId())
		{
			$this->customerSession->setCustomerAsLoggedIn($customer);
			$this->customerSession->regenerateId();

			if ($this->getCookieManager()->getCookie('mage-cache-sessid')) {
				$metadata = $this->getCookieMetadataFactory()->createCookieMetadata();
				$metadata->setPath('/');
				$this->getCookieManager()->deleteCookie('mage-cache-sessid', $metadata);
			}
		}

		$resultRaw = $this->resultFactory->create('raw');

		return $resultRaw->setContents(sprintf("<script>window.opener.socialCallback('%s', window);</script>", $this->getRedirectUrl()));
	}


	/**
	 * @return string
	 */
	protected function getRedirectUrl(){
		$url = $this->urlBuilder->getUrl('customer/account');

		if ($this->_request->getParam('authen') == 'popup') {
			$url = $this->urlBuilder->getUrl('checkout');
		} else {
			$requestedRedirect = $this->accountRedirect->getRedirectCookie();
			if (!$this->socialHelper->getConfigValue('customer/startup/redirect_dashboard') && $requestedRedirect) {
				$url = $this->_redirect->success($requestedRedirect);
				$this->accountRedirect->clearRedirectCookie();
			}
		}

		return $url;
	}

	/**
	 * Retrieve cookie manager
	 *
	 * @deprecated
	 * @return \Magento\Framework\Stdlib\Cookie\PhpCookieManager
	 */
	private function getCookieManager()
	{
		if (!$this->cookieMetadataManager) {
			$this->cookieMetadataManager = \Magento\Framework\App\ObjectManager::getInstance()->get(
				\Magento\Framework\Stdlib\Cookie\PhpCookieManager::class
			);
		}

		return $this->cookieMetadataManager;
	}

	/**
	 * Retrieve cookie metadata factory
	 *
	 * @deprecated
	 * @return \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory
	 */
	private function getCookieMetadataFactory()
	{
		if (!$this->cookieMetadataFactory) {
			$this->cookieMetadataFactory = \Magento\Framework\App\ObjectManager::getInstance()->get(
				\Magento\Framework\Stdlib\Cookie\CookieMetadataFactory::class
			);
		}

		return $this->cookieMetadataFactory;
	}

	/**
	 * @return mixed
	 */
	protected function closePopup(){
		$content = "<script type=\"text/javascript\">window.close();</script>";
		$resultRaw = $this->resultFactory->create('raw');
		return $resultRaw->setContents($content);
	}
}