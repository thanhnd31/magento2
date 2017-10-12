<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 30/08/2017
 * Time: 18:03
 */

namespace ThanhND\SocialLogin\Block;

use ThanhND\SocialLogin\Helper\Data as SocialHelper;
use Magento\Framework\View\Element\Template;

/**
 * Class Social
 * @package ThanhND\SocialLogin\Block
 */
class Social extends Template
{
	/**
	 * @var SocialHelper
	 */
    protected $socialHelper;

	/**
	 * Social constructor.
	 * @param Template\Context $context
	 * @param SocialHelper $socialHelper
	 * @param array $data
	 */
    public function __construct(
        Template\Context $context,
        SocialHelper $socialHelper,
        array $data = []){
    	$this->socialHelper = $socialHelper;
        parent::__construct($context, $data);
    }

	/**
	 * @return array
	 */
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

	/**
	 * @param $social
	 * @return string
	 */
    public function getSocialUrl($social){
        $params['app'] = $social;
        return $this->getUrl('social/account/login',$params);
    }
}