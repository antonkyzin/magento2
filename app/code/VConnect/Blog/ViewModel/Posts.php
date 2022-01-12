<?php
declare(strict_types=1);

namespace VConnect\Blog\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use VConnect\Blog\Model\ResourceModel\Post\Collection;
use VConnect\Blog\Model\ResourceModel\Post\CollectionFactory;

class Posts implements ArgumentInterface
{
    private CollectionFactory $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        return $this->collectionFactory->create();
    }
}
