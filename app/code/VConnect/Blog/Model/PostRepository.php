<?php
declare(strict_types=1);

namespace VConnect\Blog\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use VConnect\Blog\Api\Data\PostSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use VConnect\Blog\Api\PostRepositoryInterface;
use VConnect\Blog\Model\ResourceModel\Post as PostResourceModel;
use VConnect\Blog\Api\Data\PostSearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use VConnect\Blog\Api\Data\PostInterface;
use VConnect\Blog\Api\Data\PostInterfaceFactory;
use VConnect\Blog\Model\ResourceModel\Post\CollectionFactory;

class PostRepository implements PostRepositoryInterface
{
    private PostInterfaceFactory $postFactory;
    private PostResourceModel $postResourceModel;
    private PostSearchResultsInterfaceFactory $searchResultsFactory;
    private CollectionFactory $collectionFactory;
    private CollectionProcessorInterface $collectionProcessor;

    public function __construct(
        PostInterfaceFactory $postFactory,
        PostResourceModel $postResourceModel,
        PostSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->postFactory = $postFactory;
        $this->postResourceModel = $postResourceModel;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Save post.
     *
     * @param PostInterface $post
     * @return void
     * @throws CouldNotSaveException
     */
    public function save(PostInterface $post): void
    {
        try {
            $this->postResourceModel->save($post);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
    }

    /**
     * Delete post
     *
     * @param PostInterface $post
     * @return void
     * @throws CouldNotDeleteException
     */
    public function delete(PostInterface $post): void
    {
        try {
            $this->postResourceModel->delete($post);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    /**
     * Retrieve post.
     *
     * @param string $postId
     * @return PostInterface
     * @throws NoSuchEntityException
     */
    public function getById(string $postId): PostInterface
    {
        $post = $this->postFactory->create();
        $this->postResourceModel->load($post, $postId);
        if(!$post->getPostId()){
            throw new NoSuchEntityException(__('Unable to find post with ID "%1"', $postId));
        }

        return $post;
    }

    /**
     * Retrieve posts matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return PostSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): PostSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }
}
