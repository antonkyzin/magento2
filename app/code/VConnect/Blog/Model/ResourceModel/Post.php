<?php

namespace VConnect\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('vconnect_blog_posts', 'post_id');
    }
}
