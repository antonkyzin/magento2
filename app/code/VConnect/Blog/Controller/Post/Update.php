<?php
declare(strict_types=1);

namespace VConnect\Blog\Controller\Post;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use VConnect\Blog\Model\PostRepository;

class Update implements ActionInterface
{
    private PageFactory $pageFactory;

    private PostRepository $postRepository;

    private Context $context;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param PostRepository $postRepository
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        PostRepository $postRepository
    )
    {
        $this->pageFactory = $pageFactory;
        $this->postRepository = $postRepository;
        $this->context = $context;
    }

    public function execute()
    {
        $posId = $this->context->getRequest()->getPostValue('post_id');
        $post = $this->postRepository->getById($posId);
        $post->setContent('Новый контент');
        $post->setTitle('Новый title');
        $this->postRepository->save($post);

        return $this->pageFactory->create();
    }
}
