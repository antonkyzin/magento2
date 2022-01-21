<?php
declare(strict_types=1);

namespace VConnect\Blog\Model;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\CouldNotSaveException;
use VConnect\Blog\Api\Data\PostInterface;
use VConnect\Blog\Model\PostRepository;

class PostPublishingManager
{
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private PostRepository $postRepository;

    /**
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param PostRepository $postRepository
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PostRepository $postRepository
    )
    {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->postRepository = $postRepository;
    }

    /**
     * Publish posts if publish date less than now
     *
     * @return void
     */
    public function publishScheduledPosts():void
    {
        $date = date('Y-m-d H:i:s', time());
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('is_published', '0')
            ->addFilter('publish_date', $date, 'lt')
            ->create();
        $posts = $this->postRepository->getList($searchCriteria)->getItems();
        foreach ($posts as $post) {
            /** @var $post PostInterface */
            $post->setPostStatus('1');
            try {
                $this->postRepository->save($post);
            } catch (CouldNotSaveException $exception) {
                // silently skip
            }
        }
    }
}
