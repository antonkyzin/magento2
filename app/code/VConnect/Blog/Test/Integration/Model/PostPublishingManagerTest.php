<?php
declare(strict_types=1);

namespace VConnect\Blog\Test\Integration\Model;

use Magento\TestFramework\Helper\Bootstrap;
use PHPUnit\Framework\TestCase;
use VConnect\Blog\Model\PostRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * @magentoDbIsolation disabled
 */
class PostPublishingManagerTest extends TestCase
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
    public function testPublishScheduledPosts()
    {
        $date = date('Y-m-d H:i:s', time());
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('is_published', '0')
            ->addFilter('publish_date', $date, 'lt')
            ->create();
        $posts = $this->postRepository->getList($searchCriteria)->getItems();
        $this->assertNotEmpty($posts);
        foreach ($posts as $post) {
            $post->setPostStatus('1');
            $this->postRepository->save($post);
        }
        $posts = $this->postRepository->getList($searchCriteria)->getItems();
        $this->assertEmpty($posts);
    }
}
