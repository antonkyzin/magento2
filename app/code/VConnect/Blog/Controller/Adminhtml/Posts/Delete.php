<?php
declare(strict_types=1);

namespace VConnect\Blog\Controller\Adminhtml\Posts;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use VConnect\Blog\Model\PostRepository;

class Delete extends Action
{
    private PostRepository $postRepository;

    /**
     * @param Context $context
     * @param PostRepository $postRepository
     */
    public function __construct(
        Context $context,
        PostRepository $postRepository
    ){
        parent::__construct($context);
        $this->postRepository = $postRepository;
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $postId = $this->getRequest()->getParam('post_id');
        try {
            $post = $this->postRepository->getById($postId);
            $this->postRepository->delete($post);
            $this->messageManager->addSuccessMessage('Posts successfully deleted');
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect->setPath('*/*/');
    }
}
