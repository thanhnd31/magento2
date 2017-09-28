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
	protected $social;

    public function getAvailableSocials(){
        $availableSocials = array(
            "google"=>"Google",
            "facebookk"=>"Facebook",
            "twitter"=>"Twitter",
            "instagram"=>"Instagram"
        );

        return $availableSocials;
    }

    public function isEnable(){
    	if(!$this->social)
	    {
	    	return false;
	    }
		return $this->getConfigValue('thanhnd_sociallogin/'.$this->social.'/enable');
    }

    public function setSocial($social){
		$this->social = $social;
    }
}