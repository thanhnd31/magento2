<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 10/11/2016
 * Time: 16:38
 */

namespace ThanhND\FooterLink\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class GroupActions extends Column
{
    /** @var  UrlInterface */
    protected $_urlBuilder;

    /**
     * GroupActions constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components=[],
        array $data=[]
    ){
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_urlBuilder = $urlBuilder;
    }

    /**
     * Prepare data source
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['edit'] = [
                    'href' => $this->_urlBuilder->getUrl(
                        'footerlink/group/edit',
                        array('id' => $item['group_id'])
                    ),
                    'label' => __('Edit'),
                    'hidden' => false,
                    'target' => '_blank',
                ];
            }
        }

        return $dataSource;
    }
}