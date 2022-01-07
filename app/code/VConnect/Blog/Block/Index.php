<?php

namespace VConnect\Blog\Block;

use \Magento\Framework\View\Element\Template\Context;
use \VConnect\Blog\Model\PostFactory;

class Index extends \Magento\Framework\View\Element\Template
{
    protected  $collection;

    public function __construct(Context $context, \VConnect\Blog\Model\ResourceModel\Post\Collection $collection, array $data =[])
    {
        parent::__construct($context, $data);
        $this->collection = $collection;
    }

    public function getResult()
    {
        return $this->collection;
//        $post = $this->_postFactory->create();
//        $collection = $post->getCollection();
//        return $collection;
    }
}
