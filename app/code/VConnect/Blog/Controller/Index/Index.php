<?php

namespace VConnect\Blog\Controller\Index;

use \Magento\Framework\View\Result\PageFactory;

class Index implements \Magento\Framework\App\ActionInterface
{

    protected PageFactory $_pageFactory;

    public function __construct(PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
    }

    public function execute()
    {
        return $this->_pageFactory->create();
    }
}
