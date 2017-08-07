<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 07/08/2017
 * Time: 11:33
 */

namespace ThanhND\Blog\UiComponent\Options;


use Magento\Framework\Data\OptionSourceInterface;

class IsActive implements OptionSourceInterface
{
    protected $post;

    public function __construct(\ThanhND\Blog\Model\Post $post)
    {
        $this->post = $post;
    }

    public function toOptionArray()
    {
        $options[]=['label'=>'','value'=>''];
        $avalableOptions = $this->post->getAvailabeStatuses();
        foreach($avalableOptions as $key=>$value)
        {
            $options[]=['label'=>$value,'value'=>$key];
        }

        return $options;
    }
}