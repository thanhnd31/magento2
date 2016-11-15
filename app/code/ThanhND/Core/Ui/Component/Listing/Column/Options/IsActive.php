<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 10/11/2016
 * Time: 17:12
 */

namespace ThanhND\Core\Ui\Component\Listing\Column\Options;

use Magento\Framework\Option\ArrayInterface;

class IsActive implements ArrayInterface
{
    const ACTIVE = 1;
    const IN_ACTIVE = 0;

    public function toOptionArray()
    {
        $options = array(
            ['value'=>self::ACTIVE,'label'=>__('Active')],
            ['value'=>self::IN_ACTIVE,'label'=>__('In Active')]
        );

        return $options;
    }
}