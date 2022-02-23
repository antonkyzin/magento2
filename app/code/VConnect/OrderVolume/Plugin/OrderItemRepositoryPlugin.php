<?php
declare(strict_types=1);

namespace VConnect\OrderVolume\Plugin;

use Magento\Sales\Api\OrderItemRepositoryInterface;
use Magento\Sales\Api\Data\OrderItemSearchResultInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Sales\Api\Data\OrderItemExtensionInterface;
use Magento\Sales\Api\Data\OrderItemExtensionFactory;

class OrderItemRepositoryPlugin
{
    private OrderItemExtensionFactory $extensionFactory;

    /**
     * @param OrderItemExtensionFactory $extensionFactory
     */
    public function __construct(OrderItemExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * @param OrderItemRepositoryInterface $orderItemRepository
     * @param OrderItemSearchResultInterface $searchResult
     * @return OrderItemSearchResultInterface
     */
    public function afterGetList(
        OrderItemRepositoryInterface $orderItemRepository,
        OrderItemSearchResultInterface $searchResult
    ): OrderItemSearchResultInterface
    {
        foreach ($searchResult->getItems() as $orderItem) {
            $volume = $orderItem->getDataByKey('volume');
            if (isset($volume)) {
                $extensionAttributes = $this->getExtensionAttributes($orderItem);
                $extensionAttributes->setProductVolume($volume);
                $orderItem->setExtensionAttributes($extensionAttributes);
            }
        }

        return $searchResult;
    }

    /**
     * @param OrderItemRepositoryInterface $orderItemRepository
     * @param OrderItemInterface $orderItem
     * @return OrderItemInterface
     */
    public function afterGet(OrderItemRepositoryInterface $orderItemRepository, OrderItemInterface $orderItem): OrderItemInterface
    {
       $volume = $orderItem->getDataByKey('volume');
        if (isset($volume)) {
            $extensionAttributes = $this->getExtensionAttributes($orderItem);
            $extensionAttributes->setProductVolume($volume);
            $orderItem->setExtensionAttributes($extensionAttributes);
        }

        return $orderItem;
    }

    /**
     * @param OrderItemInterface $orderItem
     * @return OrderItemExtensionInterface
     */
    public function getExtensionAttributes(OrderItemInterface $orderItem): OrderItemExtensionInterface
    {
        $extensionAttributes = $orderItem->getExtensionAttributes();
        if (!isset($extensionAttributes)) {
            $extensionAttributes = $this->extensionFactory->create();
        }

        return $extensionAttributes;
    }
}
