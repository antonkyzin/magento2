<?php
declare(strict_types=1);

namespace VConnect\Blog\Controller\Adminhtml\Posts;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use VConnect\Blog\Api\PostRepositoryInterface;

class Edit extends Action
{
    private PageFactory $resultPageFactory;
    private PostRepositoryInterface $postRepository;

    public function __construct(
        Context                 $context,
        PageFactory             $resultPageFactory,
        PostRepositoryInterface $postRepository,
        ManagerInterface        $messageManager
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->postRepository = $postRepository;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $postId = $this->getRequest()->getParam('post_id');
        try {
            $this->postRepository->getById($postId);
            $resultPage->getConfig()->getTitle()->prepend((__('Edit post')));
            return $resultPage;
        } catch (NoSuchEntityException $entityException) {
            $this->messageManager->addErrorMessage($entityException->getMessage());
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }
    }
}
