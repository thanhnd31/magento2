<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 10/11/2016
 * Time: 14:16
 */

namespace ThanhND\FooterLink\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use ThanhND\FooterLink\Model\GroupFactory;

abstract class GroupAbstract extends Action
{
    /** @var  \Magento\Backend\Model\Session */
    protected $_coreSession;

    /** @var  \Magento\Framework\Registry */
    protected $_coreRegistry;

    /** @var  \Magento\Framework\View\Result\PageFactory */
    protected $_resultPageFactory;

    /** @var  \ThanhND\FooterLink\Model\GroupFactory */
    protected $_groupFactory;

    /**
     * GroupAbstract constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param GroupFactory $groupFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        PageFactory $resultPageFactory,
        GroupFactory $groupFactory
    ){
        parent::__construct($context);
        $this->_coreRegistry=$registry;
        $this->_groupFactory = $groupFactory;
        $this->_resultPageFactory = $resultPageFactory;
    }

    /**
     * Check access using manager function
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ThanhND_FooterLink::footerlink_group');
    }
}