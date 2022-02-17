<?php
declare(strict_types=1);

namespace VConnect\Blog\Api;

interface PostRepositoryInterface
{
    /**
     * Save post
     *
     * @param \VConnect\Blog\Api\Data\PostInterface $post
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(Data\PostInterface $post): void;

    /**
     * Delete post
     *
     * @param \VConnect\Blog\Api\Data\PostInterface $post
     * @return void
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(Data\PostInterface $post): void;

    /**
     * Retrieve post.
     *
     * @param string $postId
     * @return \VConnect\Blog\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
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
