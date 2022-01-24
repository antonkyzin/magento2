<?php
declare(strict_types=1);

namespace VConnect\Blog\Block\Widget;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use VConnect\Blog\Model\Post;
use VConnect\Blog\Model\PostRepository;

class Posts extends Template implements BlockInterface, IdentityInterface
{
    public const DEFAULT_POSTS_PER_PAGE = 10;
    protected $_template = 'widget/posts.phtml';
    private SortOrder $sortOrder;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private PostRepository $postRepository;
    private array $posts;

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
    }

    /**
     * Get current post or post collection
     * @return Post[]
     * @throws \Magento\Framework\Exception\InputException
     */
    public function getPosts(): array
    {
        $numberPosts = $this->getPostsPerPage();
        $this->sortOrder->setField('publish_date')->setDirection('DESC');
        $searchCriteria = $this->searchCriteriaBuilder
            ->setSortOrders([$this->sortOrder])
            ->addFilter('is_published', '1')
            ->setPageSize($numberPosts)
            ->create();
        $this->posts = $this->postRepository->getList($searchCriteria)->getItems();

        return $this->posts;
    }

    /**
     * Retrieve how many posts should be displayed
     *
     * @return int
     */
    public function getPostsPerPage(): int
    {
        if (!$this->hasData('posts_per_page')) {
            $this->setData('posts_per_page', self::DEFAULT_POSTS_PER_PAGE);
        }
        return (int)$this->getData('posts_per_page');
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
