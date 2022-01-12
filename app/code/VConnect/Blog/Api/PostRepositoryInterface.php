<?php
declare(strict_types=1);

namespace VConnect\Blog\Api;

interface PostRepositoryInterface
{
    /**
     * Save post
     *
     * @param \VConnect\Blog\Api\Data\PostInterface $post
     * @return \VConnect\Blog\Api\Data\PostInterface
     */
    public function save(Data\PostInterface $post): Data\PostInterface;

    /**
     * Delete post
     *
     * @param \VConnect\Blog\Api\Data\PostInterface $post
     * @return bool true on success
     */
    public function delete(Data\PostInterface $post): bool;

    /**
     * Retrieve post.
     *
     * @param string $postId
     * @return \VConnect\Blog\Api\Data\PostInterface
     */
    public function getById(string $postId): Data\PostInterface;

    /**
     * Retrieve blocks matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \VConnect\Blog\Api\Data\PostSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
