<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 17/11/2016
 * Time: 15:00
 */

namespace ThanhND\Core\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

abstract class GenericButton implements ButtonProviderInterface
{
    /** @var Registry  */
    protected $_registry;

    /** @var \Magento\Framework\UrlInterface  */
    protected $_urlBuilder;

    /**
     * GenericButton constructor.
     *
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        Registry $registry
    ) {
        $this->_urlBuilder = $context->getUrlBuilder();
        $this->_registry = $registry;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    private function getUrl($route = '', $params = [])
    {
        return $this->_urlBuilder->getUrl($route, $params);
    }

    /**
     * Get URL for back (reset) button
     * @param $registerKey
     * @return string
     */
    public function getBackUrl($registerKey=null)
    {
        $param = [];
        if($registerKey)
        {
            $param = [$registerKey => $this->_registry->registry($registerKey)];
        }

        return $this->getUrl('*/*/',$param);
    }

    /**
     * Get URL for delete button
     * @param $id
     * @return string
     */
    public function getDeleteUrl($id)
    {
        return $this->getUrl('*/*/delete', ['id' => $id]);
    }
}