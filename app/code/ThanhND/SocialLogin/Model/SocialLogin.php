<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 26/09/2017
 * Time: 16:22
 */

namespace ThanhND\SocialLogin\Model;

use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Registry;
use ThanhND\SocialLogin\Helper\Data as SocialHelper;
use Magento\Framework\Model\Context;

/**
 * Class SocialLogin
 * @package ThanhND\SocialLogin\Model
 */
class SocialLogin extends AbstractModel implements IdentityInterface
{
	/**
	 * cache tage
	 */
	const CACHE_TAG = 'sociallogin';

	/**
	 * @var SocialHelper
	 */
	protected $socialHelper;

	/**
	 * @var CustomerFactory
	 */
	protected $customerFactory;

	/**
	 * SocialLogin constructor.
	 * @param Context $context
	 * @param SocialHelper $socialHelper
	 * @param CustomerFactory $customerFactory
	 * @param Registry $registry
	 * @param AbstractResource|null $resource
	 * @param AbstractDb|null $resourceCollection
	 * @param array $data
	 */
	public function __construct(
		Context $context,
		SocialHelper $socialHelper,
		CustomerFactory $customerFactory,
		Registry $registry,
		AbstractResource $resource = null,
		AbstractDb $resourceCollection = null,
		array $data = [])
	{
		$this->socialHelper = $socialHelper;
		$this->customerFactory = $customerFactory;
		parent::__construct($context, $registry, $resource, $resourceCollection, $data);
	}

	/**
	 * Define resource model
	 */
	public function _construct()
	{
		$this->_init('ThanhND\SocialLogin\Model\ResourceModel\SocialLogin');
	}

	/**
	 * @return array
	 */
	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	/**
	 * @param $social
	 * @return mixed
	 * @throws \Exception
	 */
	public function getUserProfile($social)
	{
		$this->socialHelper->setSocial($social);
		$config = array(
			'base_url' => $this->socialHelper->getBaseAuthenUrl(),
			'providers' => $this->getProviderData($social),
			"debug_mode" => false
		);

		try {
			$auth = new \Hybrid_Auth($config);
			$adapter = $auth->authenticate($social, null);

			return $adapter->getUserProfile();
		} catch (\Exception $e) {
			throw $e;
		}
	}

	/**
	 * @param $socialIdentifier
	 * @param $social
	 * @return mixed
	 */
	public function getCustomer($socialIdentifier, $social)
	{
		$customer = $this->customerFactory->create();
		$socialCustomer = $this->getCollection()
			->addFieldToFilter('social_id', $socialIdentifier)
			->addFieldToFilter('type', $social)
			->getFirstItem();

		if ($socialCustomer && $socialCustomer->getId()) {
			$customer->load($socialCustomer->getCustomerId());
		}
		return $customer;
	}

	/**
	 * @param $userData
	 * @param \Magento\Store\Model\Store $store
	 * @return mixed
	 * @throws \Exception
	 */
	public function createCustomer($userData, $store)
	{
		$customer = $this->customerFactory->create();
		$customer->setWebsiteId($store->getWebsiteId());
		$customer->loadByEmail($userData['email']);

		if (!$customer->getId()) {
			$customer->setFirstname($userData['firstname'])
				->setLastname($userData['lastname'])
				->setEmail($userData['email'])
				->setStore($store);
			try {
				$customer->save();
				$this->setSocialId($userData['identifier'])
					->setCustomerId($customer->getId())
					->setType($userData['social']);
				$this->save();
			} catch (\Excepttion $e) {
				if ($customer->getId()) {
					$customer->delete();
				}
				throw $e;
			}
		}

		return $customer;
	}

	/**
	 * @return $this
	 */
	public function save()
	{
		$this->_getResource()->save($this);
		return $this;
	}

	/**
	 * @param $social
	 * @return array
	 */
	public function getProviderData($social)
	{
		$this->socialHelper->setSocial($social);
		$appId = $this->socialHelper->getAppId();
		$data = array(
			'enabled' => $this->socialHelper->isEnable(),
			'keys' => array(
				'id' => $appId,
				'key' => $appId,
				'secret' => $this->socialHelper->getAppSecret()
			)
		);

		$data = array_merge($data,$this->socialHelper->getSocialProviderData());
		return array(ucfirst($social) =>$data);
	}
}