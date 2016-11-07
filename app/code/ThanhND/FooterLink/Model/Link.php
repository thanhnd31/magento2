<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 07/11/2016
 * Time: 16:43
 */

namespace ThanhND\FooterLink\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class Link extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'thanhnd_footerlink_link';

    /**
     * Model initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ThanhND\FooterLink\Model\ResourceModel\Link');
    }

    /**
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }
}