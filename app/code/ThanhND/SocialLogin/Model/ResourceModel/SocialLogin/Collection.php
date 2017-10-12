<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 26/09/2017
 * Time: 16:32
 */

namespace ThanhND\SocialLogin\Model\ResourceModel\SocialLogin;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package ThanhND\SocialLogin\Model\ResourceModel\SocialLogin
 */
class Collection extends AbstractCollection
{
	/**
	 * Collection match Model and resource model
	 */
	public function _construct()
	{
		$this->_init('ThanhND\SocialLogin\Model\SocialLogin','ThanhND\socialLogin\Model\ResourceModel\SocialLogin');
	}
}