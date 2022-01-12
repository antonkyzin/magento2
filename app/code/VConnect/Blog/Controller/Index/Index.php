<?php
declare(strict_types=1);

namespace VConnect\Blog\Controller\Index;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\ActionInterface;

class Index implements ActionInterface
{

    protected PageFactory $pageFactory;

    /**
     * @param PageFactory $pageFactory
     */
    public function __construct(PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        return $this->pageFactory->create();
    }
}
