<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/14/2016
 * Time: 2:47 PM
 */

namespace ThanhND\SliderWidget\Ui\Component\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;
use ThanhND\SliderWidget\Model\ResourceModel\Banner\CollectionFactory as BannerCollectionFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

class BannerDataProvider extends AbstractDataProvider
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

    protected $_storeManger;
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $bannerCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        BannerCollectionFactory $bannerCollectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $bannerCollectionFactory->create();
        $this->_storeManger = $storeManager;
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
        foreach ($items as $banner) {
            $image = $banner['image'];
            if($image)
            {
                $baseUrl = $this->_storeManger->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
                $imageUrl = $baseUrl.'sliderwidget/'.$image;
                $banner['image'] = array([
                    'name'=>$image,
                    'url'=>$imageUrl
                ]);
            }

            $this->loadedData[$banner->getId()] = ['general'=>$banner->getData()];
        }

        $data = $this->getSession()->getFormData();
        if (!empty($data)) {
            $bannerId = isset($data['general']['banner_id']) ? $data['general']['banner_id'] : null;
            $this->loadedData[$bannerId] = $data;
            $this->getSession()->unsFormData();
        }

        return $this->loadedData;
    }
}