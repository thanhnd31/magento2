<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 08/11/2016
 * Time: 09:08
 */

namespace ThanhND\FooterLink\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use ThanhND\FooterLink\Model\LinkFactory;
use ThanhND\FooterLink\Model\GroupFactory;

class Link extends Template
{
    /** @var ThanhND/FooterLink/Model/LinkFactory */
    protected $_linkFactory;

    /** @var  ThanhND/FooterLink/Model/GroupFactory */
    protected $_groupFactory;

    /**
     * Link constructor.
     *
     * @param Context $context
     * @param LinkFactory $linkFactory
     * @param GroupFactory $groupFactory
     * @param array $data
     *
     * @return void
     */
    public function __construct(
        Context $context,
        LinkFactory $linkFactory,
        GroupFactory $groupFactory,
        array $data
    ){
        parent::__construct($context, $data);
        $this->_linkFactory = $linkFactory;
        $this->_groupFactory = $groupFactory;
    }

    /**
     * Get all footer link
     *
     * @return array
     */
    public function getFooterLinks()
    {
        $footerlinks = array();
        $groupModel = $this->_groupFactory->create();

        // Get all group allowed in current store
        $storeId = $this->_storeManager->getStore()->getId();
        $groupData = $groupModel->getCollection()
            ->addFieldToSelect(['group_id','group_name'])
            ->addFieldToFilter('is_active',1)
            ->addFieldToFilter('store_ids',array(
                array('like'=>'%'.$storeId.'%'),
                array('eq'=>0)
            ))
            ->setOrder('sort_order','asc')
            ->getData();

        if(empty($groupData))
        {
            return $footerlinks;
        }

        // Get all link in group
        $footerlinks = $this->getLinks($groupData);

        return $footerlinks;
    }

    public function getLinks($groups)
    {
        $links = array();

        if(empty($groups))
        {
            return $links;
        }

        $linkModel = $this->_linkFactory->create();
        foreach ($groups as $group)
        {
            $linkData = $linkModel->getCollection()
                ->addFieldToSelect(['link_name','link'])
                ->addFieldToFilter('is_active',1)
                ->addFieldToFilter('group_id',$group['group_id'])
                ->setOrder('sort_order','asc')
                ->getData();

            if(empty($linkData))
            {
                continue;
            }

             $linkItems = array();

            foreach($linkData as $link)
            {
                $linkItems[] = array(
                    'url'=>$this->getUrl($link['link']),
                    'label'=>$link['link_name']
                );
            }

            $links[$group['group_name']] = $linkItems;
        }

        return $links;
    }
}