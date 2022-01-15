<?php
declare(strict_types=1);

namespace VConnect\Blog\Controller\Adminhtml\Posts;

use Magento\Framework\Exception\CouldNotSaveException;
use VConnect\Blog\Model\PostFactory;
use VConnect\Blog\Model\PostRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Save extends Action
{
    private PostFactory $postFactory;

    private PostRepository $postRepository;

    private Context $context;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PostFactory $postFactory
     * @param PostRepository $postRepository
     */
    public function __construct(
        Context        $context,
        PostFactory    $postFactory,
        PostRepository $postRepository
    ) {
        parent::__construct($context);
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
        $this->context = $context;
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->context->getRequest()->getPostValue();
        $post = $this->postFactory->create();
        try {
            $this->postRepository->save($post->addData($data));
            $this->messageManager->addSuccessMessage('Post successfully saved');
        } catch (CouldNotSaveException $couldNotSaveException) {
            $this->messageManager->addErrorMessage($couldNotSaveException->getMessage());
        }

        return $resultRedirect->setPath('*/*/');
    }
}
