<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 30/08/2017
 * Time: 18:03
 */

namespace ThanhND\SocialLogin\Block;

use Sulaeman\SocialLogin\Model\SocialLogin;
use ThanhND\SocialLogin\Helper\Data as SocialHelper;
use Magento\Framework\View\Element\Template;

class Social extends Template
{
    protected $socialHelper;

    public function __construct(
        Template\Context $context,
        SocialLogin $socialLogin,
        array $data = []){
        parent::__construct($context, $data);
    }

    public function getSocials()
    {
        $availableSocial = $this->socialHelper->getAvailableSocials();
        foreach ($availableSocial as $social)
        {
            $this->socialHelper->isEnable($social);
        }
        $socials = [];
        return $socials;
    }

    public function getSocialUrl($social){
        $params['app'] = $social;
        return $this->getUrl('social/account/login',$params);
    }
}