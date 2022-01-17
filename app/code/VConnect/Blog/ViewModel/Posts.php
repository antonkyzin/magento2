<?php
declare(strict_types=1);

namespace VConnect\Blog\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use VConnect\Blog\Model\ResourceModel\Post\Collection;
use VConnect\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\RequestInterface;

class Posts implements ArgumentInterface
{
    private CollectionFactory $collectionFactory;
    private RequestInterface $request;

    /**
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     */
    public function __construct(CollectionFactory $collectionFactory, RequestInterface $request)
    {
        $this->collectionFactory = $collectionFactory;
        $this->request = $request;
    }

    /**
     * Get current post or post collection
     *
     * @return Collection
     */
    public function getPosts(): Collection
    {
        $requestData = $this->getRequestData();
        $collection = $this->collectionFactory->create();
        if (isset($requestData['post_id'])) {
            $collection->addFieldToFilter('post_id', $requestData['post_id']);
        }
        $collection->addFieldToFilter('is_published', '1');
        $collection->setOrder('created_at', 'DESC');
        $collection->setPageSize($requestData['page_size']);

        return $collection;
    }

    /**
     * @return array
     */
    public function getRequestData(): array
    {
        $requestData['page_size'] = $this->request->getPostValue('page_size') ?? '10';
        $requestData['post_id'] = $this->request->getParam('post_id') ?? null;

        return $requestData;
    }
}
