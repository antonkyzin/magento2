<?php
declare(strict_types=1);

namespace VConnect\Blog\Model\Post;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;
use VConnect\Blog\Api\Data\PostInterface;
use VConnect\Blog\Api\PostRepositoryInterface;
use VConnect\Blog\Model\PostFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\RequestInterface;
use VConnect\Blog\Model\ResourceModel\Post\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    protected array $loadedData;
    private PostRepositoryInterface $postRepository;
    private RequestInterface $request;
    private PostFactory $postFactory;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $postCollectionFactory
     * @param array $meta
     * @param array $data
     * @param RequestInterface|null $request
     * @param PostRepositoryInterface|null $postRepository
     * @param PostFactory|null $postFactory
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $postCollectionFactory,
        array $meta = [],
        array $data = [],
        ?RequestInterface $request = null,
        ?PostRepositoryInterface $postRepository = null,
        ?PostFactory $postFactory = null
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $postCollectionFactory->create();
        $this->request = $request ?? ObjectManager::getInstance()->get(RequestInterface::class);
        $this->postRepository = $postRepository ?? ObjectManager::getInstance()->get(PostRepositoryInterface::class);
        $this->postFactory = $postFactory ?: ObjectManager::getInstance()->get(PostFactory::class);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        if (!isset($this->loadedData)) {
            $post = $this->getCurrentPost();
            $this->loadedData[$post->getPostId()] = $post->getData();
        }

        return $this->loadedData;
    }

    /**
     * Get current post or return new post object
     *
     * @return PostInterface
     */
    private function getCurrentPost(): PostInterface
    {
        $postId = $this->getPostId();
        try {
            $post = $this->postRepository->getById($postId);
        } catch (NoSuchEntityException $noSuchEntityException) {
            $post = $this->postFactory->create();
        }

        return $post;
    }

    /**
     * Returns current post id from request
     *
     * @return string
     */
    private function getPostId(): string
    {
        return (string)$this->request->getParam($this->getRequestFieldName());
    }
}
