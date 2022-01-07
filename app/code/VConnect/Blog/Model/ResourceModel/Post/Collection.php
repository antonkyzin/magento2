<?php

namespace VConnect\Blog\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('VConnect\Blog\Model\Post', 'VConnect\Blog\Model\ResourceModel\Post');
    }

}
