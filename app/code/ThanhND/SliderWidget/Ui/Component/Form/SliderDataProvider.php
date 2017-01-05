<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/13/2016
 * Time: 4:44 PM
 */

namespace ThanhND\SliderWidget\Ui\Component\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;
use ThanhND\SliderWidget\Model\ResourceModel\Slider\CollectionFactory as SliderCollectionFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\App\ObjectManager;

class SliderDataProvider extends AbstractDataProvider
{
    /**
     * @var \Magento\Cms\Model\ResourceModel\Page\Collection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var SessionManagerInterface
     */
    protected $session;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $groupCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        SliderCollectionFactory $sliderCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $sliderCollectionFactory->create();
    }

    /**
     * Get session object
     *
     * @return SessionManagerInterface
     */
    protected function getSession()
    {
        if ($this->session === null) {
            $this->session = ObjectManager::getInstance()->get('Magento\Framework\Session\SessionManagerInterface');
        }
        return $this->session;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        /** @var $group \ThanhND\SliderWidget\Model\Slider */
        foreach ($items as $slider) {
            $this->loadedData[$slider->getId()] = ['general'=>$slider->getData()];
        }

        $data = $this->getSession()->getFormData();
        if (!empty($data)) {
            $sliderId = isset($data['general']['slider_id']) ? $data['general']['slider_id'] : null;
            $this->loadedData[$sliderId] = $data;
            $this->getSession()->unsFormData();
        }

        return $this->loadedData;
    }
}