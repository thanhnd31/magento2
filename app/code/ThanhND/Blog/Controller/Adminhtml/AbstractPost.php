<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 08/08/2017
 * Time: 11:26
 */

namespace ThanhND\Blog\Controller\Adminhtml;


use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use ThanhND\Blog\Model\PostFactory;

abstract class AbstractPost extends Action
{
    protected $resultRedirectFactory;
    protected $resultForwardFactory;
    protected $resultPageFactory;
    protected $_coreRegistry;
    protected $postFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $pageFactory,
        RedirectFactory $redirectFactory,
        ForwardFactory $forwardFactory,
        Registry $registry,
        PostFactory $postFactory
    ){
        $this->resultPageFactory = $pageFactory;
        $this->resultRedirectFactory = $redirectFactory;
        $this->resultForwardFactory = $forwardFactory;
        $this->_coreRegistry = $registry;
        $this->postFactory = $postFactory;

        parent::__construct($context);
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('ThanhND_Blog::post');
    }
}