<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 30/08/2017
 * Time: 18:03
 */

namespace ThanhND\SocialLogin\Block;

use ThanhND\SocialLogin\Model\SocialLogin;
use ThanhND\SocialLogin\Helper\Data as SocialHelper;
use Magento\Framework\View\Element\Template;

class Social extends Template
{
    protected $socialHelper;

    public function __construct(
        Template\Context $context,
//        SocialLogin $socialLogin,
        SocialHelper $socialHelper,
        array $data = []){
    	$this->socialHelper = $socialHelper;
        parent::__construct($context, $data);
    }

    public function getSocials()
    {
        $availableSocials = $this->socialHelper->getAvailableSocials();
	    $socials = [];
        foreach ($availableSocials as $social=>$label)
        {
	        $this->socialHelper->setSocial($social);
            if($this->socialHelper->isEnable()){
            	$socials[$social] = array(
            		'url'=>$this->getSocialUrl($social),
		            'label'=>$label
	            );
            }
        }

        return $socials;
    }

    public function getSocialUrl($social){
        $params['app'] = $social;
        return $this->getUrl('social/account/login',$params);
    }
}