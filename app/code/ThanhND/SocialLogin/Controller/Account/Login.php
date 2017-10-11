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

class Login extends Action
{
	protected $social;
	protected $socialHelper;

	public function __construct(
		Context $context,
		SocialHelper $socialHelper,
		SocialLogin $social
	){
		$this->social = $social;
		$this->socialHelper = $socialHelper;
		parent::__construct($context);
	}

	public function execute()
	{
		$social = $this->getRequest()->getParam('app');
		echo $social;

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
		$customer = $this->social->getCustomer($userProfile->getIdentifier,$social);
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
				return $this->closePopup();
			}
		}

		return $this->loginRedirect($customer);
	}

	protected function createCustomer($user){
			return $customer = $user;
	}

	protected function loginRedirect($customer){
		if($customer || $customer->getId())
		{
			// Set authen
			return false;
		}

		$resultRaw = $this->resultFactory->create('raw');
		$content = '<>';
		return $resultRaw->setContents($content);
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