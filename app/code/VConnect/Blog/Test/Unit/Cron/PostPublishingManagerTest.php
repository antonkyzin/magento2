<?php
declare(strict_types=1);

namespace VConnect\Blog\Test\Unit\Cron;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VConnect\Blog\Api\Data\PostInterface;
use VConnect\Blog\Model\PostPublishingManager;
use VConnect\Blog\Model\PostRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria;
use VConnect\Blog\Api\Data\PostSearchResultsInterface;
use \VConnect\Blog\Model\Post;

/**
 * @covers \VConnect\Blog\Model\PostPublishingManager
 */
class PostPublishingManagerTest extends TestCase
{
    /**
     * @var PostPublishingManager
     */
    private $postPublishingManager;

    /**
     * @var SearchCriteriaBuilder|MockObject
     */
    private $searchCriteriaBuilderMock;

    /**
     * @var PostRepository|MockObject
     */
    private $postRepository;

    /**
     * @var PostSearchResultsInterface
     */
    private $searchResultInterface;

    /**
     * @var SearchCriteria|MockObject
     */
    private $searchCriteriaMock;

    private Post $postModel;

    protected function setUp(): void
    {
        $this->postModel = $this->getMockBuilder(Post::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->postRepository = $this->createMock(PostRepository::class);
        $this->searchCriteriaBuilderMock = $this->getMockBuilder(SearchCriteriaBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->searchResultInterface = $this->getMockBuilder(PostSearchResultsInterface::class)
            ->getMockForAbstractClass();
        $this->searchCriteriaMock = $this->getMockBuilder(SearchCriteria::class)
            ->disableOriginalConstructor()->getMock();
        $this->postPublishingManager = new PostPublishingManager($this->searchCriteriaBuilderMock,$this->postRepository);
    }

    /**
     * Test execute method
     *
     * @return void
     */
    public function testPublishScheduledPosts()
    {
        $this->searchCriteriaBuilderMock->expects($this->any())
            ->method('addFilter')
            ->willReturnSelf();
        $this->searchCriteriaBuilderMock->expects($this->once())
            ->method('create')
            ->willReturn($this->searchCriteriaMock);
        $this->postRepository->expects($this->once())->method('getList')
            ->with($this->searchCriteriaMock)
            ->willReturn($this->searchResultInterface);
        $this->searchResultInterface->expects($this->once())
            ->method('getItems')
            ->willReturn($this->postModel);

    }

//    public function testSavePostException()
//    {
//
//    }
}
