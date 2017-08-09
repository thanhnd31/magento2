<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 08/08/2017
 * Time: 14:45
 */

namespace ThanhND\Blog\Block\Adminhtml\Post;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;
use \Magento\Backend\Block\Widget\Context;

class Edit extends Container
{
    protected $coreRegistry;

    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    )
    {
        $this->coreRegistry = $registry;

        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'post_id';
        $this->_blockGroup = "ThanhND_Blog";
        $this->_controller = 'adminhtml_post';

        parent::_construct();

        if ($this->_isAllowedAction('ThanhND_Blog::save')) {
            $this->buttonList->update('save', 'label', __('Save Blog Post'));
            $this->buttonList->add(
                'saveandcontinue',
                array(
                    'label' => __('Save and Continue'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => array(
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form']
                        )
                    ]
                ),
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('ThanhND_Blog::post_delete')) {
            $this->buttonList->update('delete', 'label', __('Delete Post'));
        } else {
            $this->buttonList->remove('delete');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    public function getHeaderText()
    {
        return __("Edit Post '%1'", $this->escapeHtml($this->coreRegistry->registry('blog_post')->getTitle()));
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('blog/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}