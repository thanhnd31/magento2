<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 17/07/2017
 * Time: 17:25
 */

namespace ThanhND\Blog\Model;


use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use ThanhND\Blog\Api\Data\PostInterface;

class Post extends AbstractModel implements PostInterface,IdentityInterface
{
    /**
     * Post's status
     */
    const ENABLE = 1;
    const DISABLE = 0;

    const CACHE_TAG = 'blog_post';

    protected $_cacheTag = 'thanhnd_blog_post';
    protected $_eventPrefix = 'thanhnd_blog_post';

    protected function _construct()
    {
        $this->_init('ThanhND\Blog\Model\ResourceModel\Post');
    }

    public function checkPublicKey($urlKey)
    {
        return $this->_getResource()->checkUrlKey($urlKey);
    }

    public function getAvailabeStatuses()
    {
        $statuses = array(
            self::ENABLE => __('Enable'),
            self::DISABLE => __('Disable')
        );

        return $statuses;
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    public function getId()
    {
        return $this->getData('post_id');
    }

    public function getTitle()
    {
        return $this->getData('title');
    }

    public function getContent()
    {
        return $this->getData('content');
    }

    public function getCreationTime()
    {
        return $this->getData('creation_time');
    }

    public function getUpdateTime()
    {
        return $this->getData('update_time');
    }

    public function getUrlKey()
    {
        return $this->getData('url_key');
    }

    public function isActive()
    {
        return $this->getData('is_active');
    }

    public function setId($id)
    {
        $this->setData(self::POST_ID,$id);
    }

    public function setTitle($title)
    {
        $this->setData(self::TITLE, $title);
    }

    public function setContent($content)
    {
        $this->setData(self::CONTENT, $content);
    }

    public function setIsActive($isActive)
    {
        $this->setData(self::IS_ACTIVE, $isActive);
    }

    public function setUrlKey($urlKey)
    {
        $this->setData(self::URL_KEY, $urlKey);
    }

    public function setCreationTime($creationTime)
    {
        $this->setsData(self::CREATION_TIME, $creationTime);
    }

    public function setUpdateTime($updateTime)
    {
        $this->setData(self::UPDATE_TIME, $updateTime);
    }
}