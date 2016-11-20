<?php
namespace ThanhND\FooterLink\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use ThanhND\FooterLink\Model\LinkFactory;

abstract class LinkAbstract extends Action
{
    /** @var  \Magento\Backend\Model\Session */
    protected $_coreSession;

    /** @var  \Magento\Framework\Registry */
    protected $_coreRegistry;

    /** @var  \Magento\Framework\View\Result\PageFactory */
    protected $_resultPageFactory;

    /** @var  \ThanhND\FooterLink\Model\LinkFactory */
    protected $_linkFactory;

    /** @var  \Magento\Framework\Controller\Result\JsonFactory */
    protected $_jsonFactory;

    /**
     * LinkAbstract constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param linkFactory $LinkFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        PageFactory $resultPageFactory,
        LinkFactory $linkFactory,
        JsonFactory $jsonFactory
    ){
        parent::__construct($context);
        $this->_coreRegistry=$registry;
        $this->_linkFactory = $linkFactory;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_jsonFactory = $jsonFactory;
    }

    /**
     * Check access using manager function
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ThanhND_FooterLink::footerlink_link');
    }
}