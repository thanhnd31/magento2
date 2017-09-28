<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 26/09/2017
 * Time: 16:32
 */

namespace ThanhND\SocialLogin\Model\ResourceModel\SocialLogin;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
	public function _construct()
	{
		$this->_init('ThanhND\SocialLogin\Model\SocialLogin','ThanhND\socialLogin\Model\ResourceModel\SocialLogin');
	}
}