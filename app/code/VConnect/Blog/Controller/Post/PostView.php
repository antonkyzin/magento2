<?php
declare(strict_types=1);

namespace VConnect\Blog\Controller\Post;

use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\ActionInterface;
use VConnect\Blog\Model\PostRepository;
use Magento\Framework\App\Action\Context;

class PostView implements ActionInterface
{

    private PageFactory $pageFactory;
    private PostRepository $postRepository;
    private RedirectFactory $redirectFactory;
    private Context $context;
    private ManagerInterface $messageManager;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param PostRepository $postRepository
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        Context         $context,
        PageFactory     $pageFactory,
        PostRepository  $postRepository,
        RedirectFactory $redirectFactory
    ) {
        $this->pageFactory = $pageFactory;
        $this->postRepository = $postRepository;
        $this->redirectFactory = $redirectFactory;
        $this->context = $context;
        $this->messageManager = $context->getMessageManager();
    }

    public function execute()
    {
        $postId = $this->context->getRequest()->getParam('post_id');
        try {
            $post = $this->postRepository->getById($postId);
            if ($post->getPostStatus()) {
                return $this->pageFactory->create();
            } else {
                $this->messageManager->addErrorMessage('Posts unavailable');
            }
        } catch (NoSuchEntityException $noSuchEntityException) {
            $this->messageManager->addErrorMessage($noSuchEntityException->getMessage());
        }

        return $this->redirectFactory->create()->setPath('blog');
    }
}
