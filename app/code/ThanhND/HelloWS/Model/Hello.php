<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 3/31/17
 * Time: 5:33 PM
 */

namespace ThanhND\HelloWS\Model;

use ThanhND\HelloWS\Api\HelloInterface;

class Hello implements HelloInterface
{
    /**
     * @param string $name
     * @return string
     */
    public function sayHello($name)
    {
        return 'Hello, '.$name;
    }
}