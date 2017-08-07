<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 07/08/2017
 * Time: 13:51
 */

namespace ThanhND\Blog\UiComponent\Listing;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class PostActions extends Column
{
    const BLOG_URL_PATH_EDIT = 'blog/post/edit';
    const BLOG_URL_PATH_DELETE = 'blog/post/delete';

    protected $_urlBuilder;

    private $editUrl;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        $editUrl = self::BLOG_URL_PATH_EDIT,
        array $components = [],
        array $data = [])
    {
        $this->_urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if(isset($dataSource['data']['item']))
        {
            foreach($dataSource['data']['item'] as & $item)
            {
                $name = $this->getData('name');
                if(isset($item['post_id']))
                {
                    $item[$name]['edit']=array(
                        'href'=>$this->_urlBuilder->getUrl($this->editUrl,['post_id'=>$item['post_id']]),
                        'label'=>__('Edit')
                    );
                    $item[$name]['delete'] = array(
                        'href'=>$this->_urlBuilder->getUrl(self::BLOG_URL_PATH_DELETE,['post_id'=>$item['post_id']]),
                        'label'=>__('Delete'),
                        'confirm'=>[
                            'title'=>__('Delete "${$.$data.title}"'),
                            'message'=>__('Are you sure you want\' to delete a "${$.$data.title}" record?')
                        ]
                    );
                }
            }
        }

        return $dataSource;
    }
}