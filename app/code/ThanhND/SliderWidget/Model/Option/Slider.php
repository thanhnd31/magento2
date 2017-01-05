<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/13/2016
 * Time: 9:43 AM
 */

namespace ThanhND\SliderWidget\Model\Option;

use Magento\Framework\Option\ArrayInterface;
use ThanhND\SliderWidget\Model\SliderFactory;

class Slider implements ArrayInterface
{
    protected $sliderFactory;

    public function __construct(SliderFactory $sliderFactory)
    {
        $this->sliderFactory = $sliderFactory;
    }

    public function toOptionArray()
    {
        $options = array();
        $model = $this->sliderFactory->create();

        $sliders = $model->getCollection()->addFieldToFilter('is_active',1)->getData();
        foreach ($sliders as $slider)
        {
            $options[] = array('value'=>$slider['slider_id'],'label'=>__($slider['title']));
        }

        return $options;
    }
}