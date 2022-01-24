<?php
declare(strict_types=1);

namespace VConnect\Blog\Cron;

use VConnect\Blog\Model\PostPublishingManager;

class PostPublisher
{
    private PostPublishingManager $postPublishingManager;

    /**
     * @param PostPublishingManager $postPublishingManager
     */
    public function __construct(PostPublishingManager $postPublishingManager)
    {
        $this->postPublishingManager = $postPublishingManager;
    }

    /**
     * Cron job for publishing scheduled posts.
     *
     * @return void
     */
    public function execute():void
    {
        $this->postPublishingManager->publishScheduledPosts();
    }
}
