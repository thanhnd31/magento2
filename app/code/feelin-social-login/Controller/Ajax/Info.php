<?php
/**
 * This file is part of the Sulaeman Social Login package.
 *
 * @author Sulaeman <me@sulaeman.com>
 * @copyright Copyright (c) 2017
 * @package Sulaeman_SocialLogin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// @codingStandardsIgnoreFile

namespace Sulaeman\SocialLogin\Controller\Ajax;

use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

use Sulaeman\SocialLogin\Helper\Social;
use Sulaeman\SocialLogin\Model\SocialLogin;
use Sulaeman\SocialLogin\Model\SystemConfig;

class Info extends Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Sulaeman\SocialLogin\Helper\Social
     */
    protected $helper;

    /**
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Sulaeman\SocialLogin\Helper\Social $helper
     */
    public function __construct(
        EncryptorInterface $encryptor, 
        Context $context, 
        JsonFactory $resultJsonFactory, 
        Social $helper
    )
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->helper            = $helper;
        $this->helper->setEncryptor($encryptor);

        parent::__construct($context);
    }

    /**
     * Display downloadable page bought by customer
     *
     * @return void
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $result */
        $result = $this->resultJsonFactory->create();

        if ($this->getRequest()->isAjax()) {
            $availabelLogins = [];

            foreach (SocialLogin::AVAILABLE as $key => $label) {
                $this->helper->buildXmlPath($key);

                if ($this->helper->isEnabled()
                 && $this->helper->getClientId()) {
                    $availabelLogins[] = [
                        'identifier' => $key, 
                        'label'      => $label,
                        'url'        => $this->helper->getUrl('sociallogin/auth/login', ['provider' => $key]),
                        'window'     => [
                            'width'  => (int) $this->helper->getWindowWidth(), 
                            'height' => (int) $this->helper->getWindowHeight()
                        ]
                    ];
                }
            }

            $result->setData([
                'is_enabled' => (bool) $this->helper->getConfigValue(SystemConfig::IS_ENABLED), 
                'logins'     => $availabelLogins
            ]);
        } else {
            $result->setStatusHeader(404, '1.1', 'Not Found');
            $result->setHeader('Status', '404 not found');
        }

        return $result;
    }
}
