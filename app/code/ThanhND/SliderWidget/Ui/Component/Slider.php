<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/15/2016
 * Time: 9:48 AM
 */

namespace ThanhND\SliderWidget\Ui\Component;

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

        $sliders = $model->getCollection()->getData();
        foreach ($sliders as $slider)
        {
            $options[] = array('value'=>$slider['slider_id'],'label'=>__($slider['title']));
        }

        return $options;
    }
}