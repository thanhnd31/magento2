<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 26/09/2017
 * Time: 16:28
 */

namespace ThanhND\SocialLogin\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SocialLogin extends AbstractDb
{
	public function _construct()
	{
		$this->_init('thanhnd_sociallogin','entity_id');
	}
}