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
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\Cookie\PhpCookieManager;
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
	private $cookieManager;

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
	 * @param PhpCookieManager $cookieManager
	 * @param CookieMetadataFactory $cookieMetadataFactory
	 * @param SocialLogin $social
	 */
	public function __construct(
		Context $context,
		SocialHelper $socialHelper,
		CustomerSession $customerSession,
		AccountRedirect $accountRedirect,
		PhpCookieManager $cookieManager,
		CookieMetadataFactory $cookieMetadataFactory,
		SocialLogin $social
	){
		$this->social = $social;
		$this->socialHelper = $socialHelper;
		$this->customerSession = $customerSession;
		$this->urlBuilder = $context->getUrl();
		$this->accountRedirect = $accountRedirect;
		$this->cookieManager = $cookieManager;
		$this->cookieMetadataFactory = $cookieMetadataFactory;

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
			return $this->closePopup($this->urlBuilder->getUrl('customer/account/login'));
		}

		// Get social information
		try {
			$userProfile = $this->social->getUserProfile($social);
		}catch (\Exception $e)
		{
			$message = $e->getMessage();
			$this->messageManager->addErrorMessage($message);
			return $this->closePopup($this->urlBuilder->getUrl('customer/account/login'));
		}
		if(!$userProfile->identifier){
			$message = __('Email is Null, Please enter email in your %1 profile', $social);
			$this->messageManager->addErrorMessage($message);
			return $this->closePopup($this->urlBuilder->getUrl('customer/account/login'));
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
				$store = $this->socialHelper->getStore();
				$customer = $this->social->createCustomer($user,$store);
			}catch (\Excepttion $e){
				$this->messageManager->addErrorMessage($e->getMessage());
				return $this->closePopup($this->urlBuilder->getUrl('customer/account/login'));
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

			if ($this->cookieManager->getCookie('mage-cache-sessid')) {
				$metadata = $this->cookieMetadataFactory->createCookieMetadata();
				$metadata->setPath('/');
				$this->cookieManager->deleteCookie('mage-cache-sessid', $metadata);
			}
		}

		return $this->closePopup($this->getRedirectUrl());
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
	 * @param null $url
	 * @return mixed
	 */
	protected function closePopup($url=null){
		$resultRaw = $this->resultFactory->create('raw');
		return $resultRaw->setContents(sprintf("<script>window.opener.socialCallback('%s', window);</script>", $url));
	}
}