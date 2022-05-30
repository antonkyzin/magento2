<?php
declare(strict_types=1);

namespace VConnect\OrderVolume\Block\Adminhtml\Order;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Template;
use \Magento\Framework\Registry;

class RenderVolume extends Template
{
    private Registry $registry;

    /**
     * @param Registry $registry
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Registry $registry,
        Context $context,
        array $data = []
    ) {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getVolume(): string
    {
        $order = $this->registry->registry('current_order');

        return $order->getData('volume');
    }
}
