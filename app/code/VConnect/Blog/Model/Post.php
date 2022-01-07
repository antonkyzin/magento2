<?php

namespace VConnect\Blog\Model;

class Post extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('VConnect\Blog\Model\ResourceModel\Post');
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
