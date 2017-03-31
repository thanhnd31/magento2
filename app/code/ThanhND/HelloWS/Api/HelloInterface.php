<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 3/31/17
 * Time: 5:27 PM
 */

namespace ThanhND\HelloWS\Api;

/**
 * Interface HelloInterface
 * @package ThanhND\HelloWS\Api\
 */
interface HelloInterface
{
    /**
     * @api
     * @param string $name
     * @return mixed
     */
    public function sayHello($name);
}