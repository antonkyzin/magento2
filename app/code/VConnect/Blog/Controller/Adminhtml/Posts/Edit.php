<?php
declare(strict_types=1);

namespace VConnect\Blog\Controller\Adminhtml\Posts;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use VConnect\Blog\Api\PostRepositoryInterface;

class Edit extends Action
{
    private PageFactory $resultPageFactory;
    private PostRepositoryInterface $postRepository;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        PostRepositoryInterface $postRepository

    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->postRepository = $postRepository;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Edit post')));

        return $resultPage;
    }
}
