<?php
declare(strict_types=1);

namespace VConnect\Blog\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use VConnect\Blog\Model\Post;
use VConnect\Blog\Model\ResourceModel\Post as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(Post::class, ResourceModel::class);
    }
}
