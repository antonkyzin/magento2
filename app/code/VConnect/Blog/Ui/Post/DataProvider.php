<?php
declare(strict_types=1);

namespace VConnect\Blog\Ui\Post;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\AbstractDataProvider;
use VConnect\Blog\Api\Data\PostInterface;
use VConnect\Blog\Api\PostRepositoryInterface;
use VConnect\Blog\Api\Data\PostInterfaceFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\RequestInterface;
use VConnect\Blog\Model\ResourceModel\Post\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    protected array $loadedData;
    private PostRepositoryInterface $postRepository;
    private RequestInterface $request;
    private PostInterfaceFactory $postFactory;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $postCollectionFactory
     * @param array $meta
     * @param array $data
     * @param RequestInterface|null $request
     * @param PostRepositoryInterface|null $postRepository
     * @param PostInterfaceFactory|null $postFactory
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
        ?PostInterfaceFactory $postFactory = null
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $postCollectionFactory->create();
        $this->request = $request ?? ObjectManager::getInstance()->get(RequestInterface::class);
        $this->postRepository = $postRepository ?? ObjectManager::getInstance()->get(PostRepositoryInterface::class);
        $this->postFactory = $postFactory ?: ObjectManager::getInstance()->get(PostInterfaceFactory::class);
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
        if (!isset($postId)) {
            $post = $this->postFactory->create();
        } else {
            try {
                $post = $this->postRepository->getById($postId);
            } catch (NoSuchEntityException $noSuchEntityException) {
                $post = $this->postFactory->create();
            }
        }
        return $post;
    }

    /**
     * Returns current post id from request
     *
     * @return string|null
     */
    private function getPostId(): ?string
    {
        return $this->request->getParam($this->getRequestFieldName()) ?? null;
    }
}
