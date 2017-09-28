<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 26/09/2017
 * Time: 16:22
 */

namespace ThanhND\SocialLogin\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class SocialLogin extends AbstractModel implements IdentityInterface
{
	const CACHE_TAG = 'sociallogin';

	public function _construct()
	{
		$this->_init('ThanhND\SocialLogin\Model\ResourceModel\SocialLogin');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG.'_'.$this->getId()];
	}
}