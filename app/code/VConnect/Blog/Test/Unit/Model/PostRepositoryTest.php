<?php
declare(strict_types=1);

namespace VConnect\Blog\Test\Unit\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VConnect\Blog\Api\Data\PostInterfaceFactory;
use VConnect\Blog\Model\ResourceModel\Post as PostResourceModel;
use VConnect\Blog\Model\PostRepository;
use VConnect\Blog\Model\Post;
use VConnect\Blog\Api\Data\PostSearchResultsInterfaceFactory;
use VConnect\Blog\Api\Data\PostSearchResultsInterface;
use VConnect\Blog\Model\ResourceModel\Post\CollectionFactory;
use VConnect\Blog\Model\ResourceModel\Post\Collection;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class PostRepositoryTest extends TestCase
{
    /**
     * @var Post|MockObject
     */
    private $post;
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var PostResourceModel|MockObject
     */
    private $postResourceModel;

    /**
     * @var PostSearchResultsInterfaceFactory|MockObject
     */
    private $searchResultsFactory;

    /**
     * @var PostSearchResultsInterface
     */
    private $searchResult;

    /**
     * @var CollectionFactory|MockObject
     */
    private $collectionFactory;

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var CollectionProcessorInterface|MockObject
     */
    private  $collectionProcessor;

    protected function setUp(): void
    {
        $this->post = $this->getMockBuilder(Post::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->postResourceModel = $this->getMockBuilder(PostResourceModel::class)
            ->disableOriginalConstructor()
            ->getMock();
        $postFactory = $this->getMockBuilder(PostInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->searchResultsFactory = $this->getMockBuilder(PostSearchResultsInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->collectionFactory = $this->getMockBuilder(CollectionFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->collectionProcessor = $this->getMockBuilder(CollectionProcessorInterface::class)
            ->getMockForAbstractClass();
        $this->collection = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->searchResult = $this->getMockBuilder(PostSearchResultsInterface::class)
            ->getMock();

        $postFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->post);

        $this->postRepository = new PostRepository(
            $postFactory,
            $this->postResourceModel,
            $this->searchResultsFactory,
            $this->collectionFactory,
            $this->collectionProcessor
        );
    }

    public function testSave(): void
    {
        $this->postResourceModel->expects($this->once())
            ->method('save')
            ->with($this->post)
            ->willReturnSelf();
        $this->postRepository->save($this->post);
    }

    public function testSaveThrowsException(): void
    {
        $this->expectException('Magento\Framework\Exception\CouldNotSaveException');
        $this->postResourceModel->expects($this->once())
            ->method('save')
            ->with($this->post)
            ->willThrowException(new \Exception());
        $this->postRepository->save($this->post);
    }

    public function testDelete(): void
    {
        $this->postResourceModel->expects($this->once())
            ->method('delete')
            ->with($this->post)
            ->willReturnSelf();
        $this->postRepository->delete($this->post);
    }

    public function testDeleteThrowsException()
    {
        $this->expectException('Magento\Framework\Exception\CouldNotDeleteException');
        $this->postResourceModel->expects($this->once())
            ->method('delete')
            ->with($this->post)
            ->willThrowException(new \Exception());
        $this->postRepository->delete($this->post);
    }

    public function testGetById(): void
    {
        $postId = '1';
        $this->postResourceModel->expects($this->once())
            ->method('load')
            ->with($this->post, $postId)
            ->willReturn($this->post);
        $this->post->expects($this->once())
            ->method('getPostId')
            ->willReturn($postId);
        $this->assertEquals($this->post, $this->postRepository->getById($postId));
    }

    public function testGetByIdThrowsException(): void
    {
        $postId = '1';
        $this->postResourceModel->expects($this->once())
            ->method('load')
            ->with($this->post, $postId)
            ->willReturn($this->post);
        $this->post->expects($this->once())
            ->method('getPostId')
            ->willReturn(null);
        $exception = new NoSuchEntityException(__('Unable to find post with ID "%1"', $postId));
        $this->expectExceptionObject($exception);
        $this->postRepository->getById($postId);
    }

    public function testGetList(): void
    {
        /** @var SearchCriteriaInterface $criteria */
        $criteria = $this->getMockBuilder(SearchCriteriaInterface::class)
            ->getMock();

        $this->collectionFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->collection);
        $this->searchResultsFactory->expects($this->once())
            ->method('create')
            ->willReturn($this->searchResult);
        $this->searchResult->expects($this->once())
            ->method('setSearchCriteria')
            ->with($criteria)
            ->willReturnSelf();
        $this->searchResult->expects($this->once())
            ->method('setItems')
            ->with([$this->post])
            ->willReturnSelf();
        $this->collectionProcessor->expects($this->once())
            ->method('process')
            ->with($criteria, $this->collection)
            ->willReturnSelf();
        $this->collection->expects($this->once())
            ->method('getItems')
            ->willReturn([$this->post]);

        $this->assertEquals($this->searchResult, $this->postRepository->getList($criteria));
    }
}
