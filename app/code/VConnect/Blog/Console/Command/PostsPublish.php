<?php
declare(strict_types=1);

namespace VConnect\Blog\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VConnect\Blog\Model\PostPublishingManager;

class PostsPublish extends Command
{
    private PostPublishingManager $postPublishingManager;

    /**
     * @param PostPublishingManager $postPublishingManager
     */
    public function __construct(PostPublishingManager $postPublishingManager)
    {
        $this->postPublishingManager = $postPublishingManager;
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('posts:publish');
        $this->setDescription('Run Cron job for publishing posts.');
    }

    /**
     * Publish scheduled posts
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->postPublishingManager->publishScheduledPosts();
    }
}
