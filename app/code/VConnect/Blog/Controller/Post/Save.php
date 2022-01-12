<?php
declare(strict_types=1);

namespace VConnect\Blog\Controller\Post;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use VConnect\Blog\Model\PostFactory;
use VConnect\Blog\Model\PostRepository;

class Save implements ActionInterface
{
    private PageFactory $pageFactory;

    private PostFactory $postFactory;

    private PostRepository $postRepository;

    /**
     * Index constructor.
     * @param PageFactory $pageFactory
     * @param PostFactory $postFactory
     * @param PostRepository $postRepository
     */
    public function __construct(
        PageFactory $pageFactory,
        PostFactory $postFactory,
        PostRepository $postRepository
    )
    {
        $this->pageFactory = $pageFactory;
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
    }

    public function execute()
    {
        $data = [
            "title" => "Title",
            "content" => "ContentContentContentContentContentContent",
            "announce" => "Announce",
            "publish_date" => '2022-01-10 12:01:12',
            "is_published" => 1,
            "created_at" => '2022-01-10 12:01:12',
            "updated_at" => '2022-01-10 12:01:12'
        ];
        $post = $this->postFactory->create();
        $this->postRepository->save($post->addData($data));

        return $this->pageFactory->create();
    }
}
