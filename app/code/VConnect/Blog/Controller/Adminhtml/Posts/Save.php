<?php
declare(strict_types=1);

namespace VConnect\Blog\Controller\Adminhtml\Posts;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Filter\FilterManager;
use VConnect\Blog\Api\Data\PostInterfaceFactory;
use VConnect\Blog\Model\PostRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Save extends Action
{
    private PostInterfaceFactory $postFactory;
    private PostRepository $postRepository;
    private Context $context;
    private FilterManager $filterManager;

    /**
     * @param Context $context
     * @param PostInterfaceFactory $postFactory
     * @param PostRepository $postRepository
     * @param FilterManager $filterManager
     */
    public function __construct(
        Context $context,
        PostInterfaceFactory $postFactory,
        PostRepository $postRepository,
        FilterManager $filterManager
    ) {
        parent::__construct($context);
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
        $this->context = $context;
        $this->filterManager = $filterManager;
    }

    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->context->getRequest()->getPostValue();
        $post = $this->postFactory->create();
        if (isset($data['post_id'])) {
            $post->setPostId($data['post_id']);
        }
        if (isset($data['publish_date'])) {
            $post->setPublishDate($data['publish_date']);
        }
        $post->setTitle($data['title']);
        $post->setContent($data['content']);
        $post->setAnnounce($data['announce']);
        $post->setPostStatus($data['is_published']);
        $urlKey = $data['url_key'] ? : $data['title'];
        $post->setUrlKey($this->filterManager->translitUrl($urlKey));
        try {
            $this->postRepository->save($post);
            $this->messageManager->addSuccessMessage('Posts successfully saved');
        } catch (CouldNotSaveException $couldNotSaveException) {
            $this->messageManager->addErrorMessage($couldNotSaveException->getMessage());
        }

        return $resultRedirect->setPath('*/*/');
    }
}
