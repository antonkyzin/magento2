<?php
declare(strict_types=1);

namespace VConnect\Blog\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use VConnect\Blog\Model\PostRepository;

class Router implements RouterInterface
{
    private ActionFactory $actionFactory;
    private PostRepository $postRepository;

    /**
     * @param ActionFactory $actionFactory
     * @param PostRepository $postRepository
     */
    public function __construct(
        ActionFactory $actionFactory,
        PostRepository $postRepository
    ) {
        $this->actionFactory = $actionFactory;
        $this->postRepository = $postRepository;
    }

    /**
     * Match application action by request
     *
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        try {
            $post = $this->postRepository->getByUrlKey($identifier);
            $request->setModuleName('blog')
                ->setControllerName('post')
                ->setActionName('postview')
                ->setParam('post_id', $post->getPostId());
            return $this->actionFactory->create(\Magento\Framework\App\Action\Forward::class);
        } catch (NoSuchEntityException $exception) {
           return null;
        }
    }
}
