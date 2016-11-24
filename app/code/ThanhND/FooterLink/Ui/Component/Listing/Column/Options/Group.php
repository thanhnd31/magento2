<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 24/11/2016
 * Time: 15:20
 */

namespace ThanhND\FooterLink\Ui\Component\Listing\Column\Options;

use Magento\Framework\Option\ArrayInterface;
use ThanhND\FooterLink\Model\GroupFactory;

class Group implements ArrayInterface
{
    protected $_groupFactory;

    public function __construct(GroupFactory $groupFactory)
    {
        $this->_groupFactory = $groupFactory;
    }

    public function toOptionArray()
    {
        $options = array();
        $model = $this->_groupFactory->create();

        $groups = $model->getCollection()->getData();
        foreach ($groups as $group)
        {
            $options[] = array('value'=>$group['group_id'],'label'=>__($group['group_name']));
        }

        return $options;
    }
}