<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 10/11/2016
 * Time: 17:21
 */

namespace ThanhND\Core\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\System\Store as SystemStore;

class StoreViews extends Column
{
    /** @var SystemStore */
    protected $systemStore;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
        SystemStore $systemStore
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->systemStore = $systemStore;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = $this->prepareItem($item);
            }
        }
        return $dataSource;
    }

    /**
     * @param array $item
     * @return \Magento\Framework\Phrase|string
     */
    protected function prepareItem(array $item)
    {
        $content = '';
        if (!isset($item['store_ids']) || '' == $item['store_ids']) {
            return '';
        }

        $storeIds = explode(',',$item['store_ids']);
        if (in_array(0, $storeIds)) {
            return __('All Store Views');
        }

        $data = $this->systemStore->getStoresStructure(false, $storeIds);
        $nonEscapableNbspChar = html_entity_decode('&#160;', ENT_NOQUOTES, 'UTF-8');

        foreach ($data as $website) {
            $content .= $website['label'] . "<br/>";
            foreach ($website['children'] as $group) {
                $content .= str_repeat($nonEscapableNbspChar, 3).$group['label'] . "<br/>";
                foreach ($group['children'] as $store) {
                    $content .= str_repeat($nonEscapableNbspChar, 6).$store['label'] . "<br/>";
                }
            }
        }

        return $content;
    }
}