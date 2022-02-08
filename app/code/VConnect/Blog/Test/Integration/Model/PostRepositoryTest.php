<?php
declare(strict_types=1);

namespace VConnect\Blog\Test\Integration\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;
use VConnect\Blog\Model\PostRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * @magentoDbIsolation disabled
 */
class PostRepositoryTest extends TestCase
{
    private ?PostRepository $postRepository;
    private ?SearchCriteriaBuilder $searchCriteriaBuilder;

    protected function setUp(): void
    {
        $this->postRepository = Bootstrap::getObjectManager()->create(PostRepository::class);
        $this->searchCriteriaBuilder = Bootstrap::getObjectManager()->create(SearchCriteriaBuilder::class);
    }

    /**
     * @magentoDataFixture VConnect_Blog::Test/_files/post.php
     */
    public function testSave(): void
    {
        /**
         * We are using post id "2" because data fixture saves post with id "2"
         */
        $post = $this->postRepository->getById('2');
        $this->assertEquals('Title', $post->getTitle());
        $this->assertEquals('Content content', $post->getContent());
        $this->assertEquals('Announce', $post->getAnnounce());
        $this->assertEquals('url_key_for_post_1', $post->getUrlKey());
    }

    public function testGetList(): void
    {
        /**
         * We are using value "Title" for filter because data fixture saves post with title "Title"
         */
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('title', 'Title')
            ->create();
        $posts = $this->postRepository->getList($searchCriteria);
        $this->assertInstanceOf('\VConnect\Blog\Api\Data\PostSearchResultsInterface', $posts);
        $arrayOfPosts = $posts->getItems();
        foreach ($arrayOfPosts as $post) {
            $this->assertEquals('Title', $post->getTitle());
        }
    }

    public function testDelete(): void
    {
        /**
         * We are using post id "2" because data fixture saves post with id "2"
         */
        $post = $this->postRepository->getById('2');
        $this->postRepository->delete($post);
        $exception = new NoSuchEntityException(__('Unable to find post with ID "2"'));
        $this->expectExceptionObject($exception);
        $this->postRepository->getById('2');
    }
}
