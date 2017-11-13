<?php
/**
 * Created by PhpStorm.
 * User: thanhnd1
 * Date: 08/08/2017
 * Time: 11:37
 */

namespace ThanhND\Blog\Controller\Adminhtml;


use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;
use ThanhND\Blog\Model\ResourceModel\Post\CollectionFactory;

abstract class AbstractPostMassActions extends Action
{
    const TYPE_REDIRECT = 'redirect';

    protected $filter;
    protected $collectionFactory;

    public function __construct(
        Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ){
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;

        parent::__construct($context);
    }
}