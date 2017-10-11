<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 09/10/2017
 * Time: 10:02
 */

namespace ThanhND\SocialLogin\Controller\Account;


use Magento\Framework\App\Action\Action;

class Callback extends Action
{
	public function execute()
	{
		\Hybrid_Endpoint::process();
	}
}