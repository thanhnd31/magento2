<?php
/**
 * Created by PhpStorm.
 * User: smart
 * Date: 9/15/2016
 * Time: 4:13 PM
 */

namespace ThanhND\SliderWidget\Block\Adminhtml\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use ThanhND\SliderWidget\Model\ResourceModel\Banner\CollectionFactory as BannerCollectionFactory;
use Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory as DataProviderColelctionFactory;
use Magento\Framework\Registry;

class Banners extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    protected $collectionFactory;

    protected $_bannerCollectionFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        BannerCollectionFactory $bannerCollectionFactory,
        DataProviderColelctionFactory $collectionFactory,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->collectionFactory = $collectionFactory;
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        parent::__construct($context, $backendHelper,$data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('slider_banners_grid');
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);

        if ($this->getRequest()->getParam('id')) {
            $this->setDefaultFilter(['banner_id' => 1]);
        }
    }

    /**
     * Apply various selection filters to prepare the sales order grid collection.
     *
     * @return $this
     */
    protected function _prepareCollection()
    {
//        $collection = $this->_collectionFactory->create()->addFieldToSelect('*');
        $collection = $this->collectionFactory->getReport('banner_listing_data_source')->addFieldToSelect('*');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * {@inheritdoc}
     */
    protected function _prepareColumns()
    {
        $this->addColumn('banner_id', ['header' => __('Banner'), 'width' => '100', 'index' => 'banner_id']);
        $this->addColumn('image', [
            'header' => __('Image'),
            'index' => 'image',
            'renderer'=> '\ThanhND\SliderWidget\Block\Adminhtml\Edit\Tab\Banners\Image'
        ]);
        $this->addColumn('title', ['header' => __('Title'), 'index' => 'title']);
        $this->addColumn('link', [
            'header' => __('Target Link'),
            'index' => 'link',
            'renderer'=> '\ThanhND\SliderWidget\Block\Adminhtml\Edit\Tab\Banners\Link'
        ]);
        $this->addColumn('status', [
            'header' => __('Status'),
            'index' => 'status',
            //'type'=>'select',
            //'values' => array('Enabled','Disabled')
        ]);

        return parent::_prepareColumns();
    }

    protected function _getSelectedBanners()
    {
        $sliderId = $this->getRequest()->getParam('id');
        $bannerIds = $this->_bannerCollectionFactory->create()
            ->addFieldToFilter('slider_id',$sliderId)
            ->getAllIds();

        return $bannerIds;
    }

    /**
     * Add filter
     *
     * @param Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in product flag
        if ($column->getId() == 'banner_id') {
            $bannerIds = $this->_getSelectedBanners();
            if (empty($bannerIds)) {
                $bannerIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('banner_id', ['in' => $bannerIds]);
            } else {
                if ($bannerIds) {
                    $this->getCollection()->addFieldToFilter('banner_id', ['nin' => $bannerIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
}