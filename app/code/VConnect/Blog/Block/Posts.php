<?php
declare(strict_types=1);

namespace VConnect\Blog\Block;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use VConnect\Blog\Model\Post;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use VConnect\Blog\Model\PostRepository;

class Posts extends Template implements IdentityInterface
{
    private SortOrder $sortOrder;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private PostRepository $postRepository;
    private array $posts;
    private Template\Context $context;

    /**
     * @param Template\Context $context
     * @param SortOrder $sortOrder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param PostRepository $postRepository
     * @param array $data
     */
    public function __construct(
        Template\Context  $context,
        SortOrder $sortOrder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PostRepository $postRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->sortOrder = $sortOrder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->postRepository = $postRepository;
        $this->context = $context;
    }

    /**
     * Get current post or post collection
     *
     */
    public function getPosts(): array
    {
//        $currentPage = $this->context->getRequest()->getParam('page') ?? '1';
        $this->sortOrder->setField('publish_date')->setDirection('DESC');
        $searchCriteria = $this->searchCriteriaBuilder
            ->setSortOrders([$this->sortOrder])
            ->addFilter('is_published', '1')
            ->setPageSize(10)
//            ->setCurrentPage($currentPage)
            ->create();
        $this->posts = $this->postRepository->getList($searchCriteria)->getItems();

        return $this->posts;
    }

    /**
     * Return unique ID(s) for each post
     *
     * @return array
     */
    public function getIdentities(): array
    {
        $cacheTags = [];
        foreach ($this->posts as $post) {
            $cacheTags[] = Post::CACHE_TAG . '_' . $post->getPostId();
        }

        return $cacheTags;
    }
}
