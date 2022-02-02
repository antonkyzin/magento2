<?php
declare(strict_types=1);

namespace VConnect\Blog\Controller;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use VConnect\Blog\Model\PostRepository;

class Router implements RouterInterface
{
    private ActionFactory $actionFactory;
    private PostRepository $postRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param ActionFactory $actionFactory
     * @param PostRepository $postRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        ActionFactory $actionFactory,
        PostRepository $postRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->actionFactory = $actionFactory;
        $this->postRepository = $postRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Match application action by request
     *
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        $identifier = trim($request->getPathInfo(), '/');
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('is_published', '1')
            ->addFilter('url_key', $identifier)
            ->create();;
            $post = $this->postRepository->getList($searchCriteria)->getItems();
            if (empty($post)) {
                return null;
            }
            $postId = array_shift($post)->getPostId();
            $request->setModuleName('blog')
                ->setControllerName('post')
                ->setActionName('postview')
                ->setParam('post_id', $postId);

            return $this->actionFactory->create(\Magento\Framework\App\Action\Forward::class);
    }
}
