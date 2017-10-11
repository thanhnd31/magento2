<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 31/08/2017
 * Time: 14:05
 */

namespace ThanhND\SocialLogin\Helper;


class Data extends \ThanhND\Core\Helper\Data
{
	const PROVIDER_DATA = array(
		'facebook'  => ["trustForwarded" => false, 'scope' => 'email, user_about_me'],
		'twitter'   => ["includeEmail" => true],
		'linkedIn'  => ["fields" => ['id', 'first-name', 'last-name', 'email-address']],
		'vkontakte' => ['wrapper' => ['class' => '\ThanhND\SocialLogin\Model\Providers\Vkontakte']],
		'instagram' => ['wrapper' => ['class' => '\ThanhND\SocialLogin\Model\Providers\Instagram']],
		'github'    => ['wrapper' => ['class' => '\ThanhND\SocialLogin\Model\Providers\GitHub']],
		'amazon'    => ['wrapper' => ['class' => '\ThanhND\SocialLogin\Model\Providers\Amazon']]
	);
	const AVAILABLE_SOCIALS = array(
		"google"=>"Google",
		"facebookk"=>"Facebook",
		"twitter"=>"Twitter",
		"instagram"=>"Instagram"
	);
	/**
	 * @var $social: Social Type
	 */
	protected $social;

	/**
	 * @return array
	 */
    public function getAvailableSocials(){
        return self::AVAILABLE_SOCIALS;
    }

    public function isAvailableSocial($social){
		if(!isset(self::AVAILABLE_SOCIALS[$social])){
			return false;
		}

	    if(self::AVAILABLE_SOCIALS[$social]){
		    return true;
	    }
		return false;
    }

	/**
	 * @return bool|mixed
	 */
    public function isEnable(){
    	if(!$this->social)
	    {
	    	return false;
	    }
		return $this->getConfigValue('thanhnd_sociallogin/'.$this->social.'/enable');
    }

	/**
	 * @param $social
	 */
    public function setSocial($social){
		$this->social = $social;
    }

	/**
	 * @return string
	 */
    public function getBaseAuthenUrl(){
    	$url = $this->_getUrl('social/account/callback', array('_nosid' => true, '_scope' => $this->getStoreScope()));
	    return $url;
    }

	/**
	 * @return int
	 */
	protected function getStoreScope()
	{
		$scope = $this->_request->getParam(\Magento\Store\Model\ScopeInterface::SCOPE_STORE) ?: $this->storeManager->getStore()->getId();

		if ($website = $this->_request->getParam(\Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE)) {
			$scope = $this->storeManager->getWebsite($website)->getDefaultStore()->getId();
		}

		return $scope;
	}

	/**
	 * @return mixed
	 */
	public function getAppId(){
    	return $this->getConfigValue('thanhnd_sociallogin/'.$this->social.'/app_id');
	}

	/**
	 * @return mixed
	 */
	public function getAppSecret(){
		return $this->getConfigValue('thanhnd_sociallogin/'.$this->social.'/app_secret');
	}

	/**
	 * @return mixed
	 */
	public function getSocialProviderData(){
		return self::PROVIDER_DATA[$this->social];
	}

	public function getSocialConfig(){
		return [];
	}

	public function getSocial(){
		return $this->social;
	}
}