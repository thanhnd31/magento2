<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 17/07/2017
 * Time: 17:18
 */

namespace ThanhND\Blog\Api\Data;


interface PostInterface
{
    const POST_ID = 'post_id';
    const URL_KEY = 'url_key';
    const TITLE = 'title';
    const CONTENT = 'content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const IS_ACTIVE = 'is_active';

    public function getId();
    public function getUrlKey();
    public function getTitle();
    public function getContent();
    public function getCreationTime();
    public function getUpdateTime();
    public function isActive();

    public function setId($id);
    public function setUrlKey($urlKey);
    public function setTitle($title);
    public function setContent($content);
    public function setCreationTime($creationTime);
    public function setUpdateTime($updateTime);
    public function setIsActive($isActive);
}