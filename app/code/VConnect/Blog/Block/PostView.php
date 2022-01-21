<?php
declare(strict_types=1);

namespace VConnect\Blog\Block;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use VConnect\Blog\Model\Post;
use VConnect\Blog\Model\PostRepository;

class PostView extends Template implements IdentityInterface
{
    private RequestInterface $request;
    private PostRepository $postRepository;
    private ?Post $post;

    /**
     * @param Template\Context $context
     * @param RequestInterface $request
     * @param PostRepository $postRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        PostRepository   $postRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->request = $request;
        $this->postRepository = $postRepository;
    }

    /**
     * Get post by id
     *
     * @return Post
     */
    public function getPost(): ?Post
    {
        $postId = $this->request->getParam('post_id');
        try {
            $this->post = $this->postRepository->getById($postId);
        } catch (NoSuchEntityException $noSuchEntityException) {
            $this->post = null;
        }

        return $this->post;
    }

    public function getIdentities(): array
    {
        $cacheTag[] = Post::CACHE_TAG . '_';
        if (isset($this->post)) {
            $cacheTag[0] .= $this->post->getPostId();
        }

        return $cacheTag;
    }
}
