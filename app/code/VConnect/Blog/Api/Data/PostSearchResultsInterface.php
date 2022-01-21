<?php

namespace VConnect\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PostSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \VConnect\Blog\Api\Data\PostInterface
     */
    public function getItems();

    /**
     * @param \VConnect\Blog\Api\Data\PostInterface $items
     * @return $this
     */
    public function setItems(array $items);
}
