<?php
declare(strict_types=1);

namespace VConnect\OrderVolume\Plugin;

use Magento\Quote\Model\Quote\Item\ToOrderItem;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Quote\Api\Data\CartItemInterface;

class SetVolumeToOrderItemPlugin
{
    /**
     * Set attribute 'volume' in order item entity
     *
     * @param ToOrderItem $subject
     * @param OrderItemInterface $orderItem
     * @param CartItemInterface $item
     * @param array $data
     * @return OrderItemInterface
     */
    public function afterConvert(
        ToOrderItem $subject,
        OrderItemInterface $orderItem,
        CartItemInterface $item,
        array $data=[]
    ): OrderItemInterface
    {
        $orderItem->setData('volume', $item->getData('volume'));

        return $orderItem;
    }
}
