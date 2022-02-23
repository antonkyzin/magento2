<?php
declare(strict_types=1);

namespace VConnect\OrderVolume\Plugin;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderExtensionInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderSearchResultInterface;

class OrderRepositoryPlugin
{
    private OrderExtensionFactory $extensionFactory;

    /**
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(OrderExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param OrderInterface $order
     * @return void
     */
    public function beforeSave(OrderRepositoryInterface $orderRepository, OrderInterface $order)
    {
        $orderVolume = 0;
        $items = $order->getItems();
        /**
         * @var \Magento\Sales\Api\Data\OrderItemInterface $item;
         */
        foreach ($items as $item) {
            $itemVolume = (float)$item->getDataByKey('volume');
            $qty = $item->getQtyOrdered();
            $orderVolume += $itemVolume * $qty;
        }
        $order->setData('volume', $orderVolume);
    }

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $orderRepository, OrderInterface $order)
    {
        $volume = $order->getDataByKey('volume');
        $extensionAttributes = $this->getExtensionAttributes($order);
        $extensionAttributes->setOrderVolume($volume);
        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param OrderSearchResultInterface $searchResult
     * @return OrderSearchResultInterface
     */
    public function afterGetList(
        OrderRepositoryInterface $orderRepository,
        OrderSearchResultInterface $searchResult
    ): OrderSearchResultInterface
    {
        $orders = $searchResult->getItems();
        foreach ($orders as $order) {
            $volume = $order->getDataByKey('volume');
            $extensionAttributes = $this->getExtensionAttributes($order);
            $extensionAttributes->setOrderVolume($volume);
            $order->setExtensionAttributes($extensionAttributes);
        }

        return $searchResult;
    }

    /**
     * @param OrderInterface $order
     * @return OrderExtensionInterface
     */
    public function getExtensionAttributes(OrderInterface $order): OrderExtensionInterface
    {
        $extensionAttributes = $order->getExtensionAttributes();
        if (!isset($extensionAttributes)) {
            $extensionAttributes = $this->extensionFactory->create();
        }

        return $extensionAttributes;
    }
}
