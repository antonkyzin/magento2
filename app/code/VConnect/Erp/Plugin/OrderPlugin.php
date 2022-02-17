<?php
declare(strict_types=1);

namespace VConnect\Erp\Plugin;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderExtensionInterface;

class OrderPlugin
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
     * @param OrderRepositoryInterface $orderRepositoryInterface
     * @param OrderInterface $order
     * @return void
     */
    public function beforeSave(OrderRepositoryInterface $orderRepositoryInterface, OrderInterface $order)
    {
        $erpId = $this->getExtensionAttributes($order)->getExtensionErpId();
        if ($erpId) {
            $order->setData('extension_erp_id', $erpId);
        }
    }

    /**
     * @param OrderRepositoryInterface $orderRepositoryInterface
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $orderRepositoryInterface, OrderInterface $order): OrderInterface
    {
        $erpId = $order->getDataByKey('extension_erp_id');
            if ($erpId) {
                $extensionAttributes = $this->getExtensionAttributes($order);
                $extensionAttributes->setExtensionErpId($erpId);
                $order->setExtensionAttributes($extensionAttributes);
        }

        return $order;
    }

    /**
     * @param OrderRepositoryInterface $orderRepositoryInterface
     * @param OrderSearchResultInterface $searchResults
     * @return OrderSearchResultInterface
     */
    public function afterGetList(
        OrderRepositoryInterface $orderRepositoryInterface,
        OrderSearchResultInterface $searchResults
    ): OrderSearchResultInterface
    {
        foreach ($searchResults->getItems() as $order) {
            $erpId = $order->getDataByKey('extension_erp_id');
            if (isset($erpId)) {
                $extensionAttributes = $this->getExtensionAttributes($order);
                $extensionAttributes->setExtensionErpId($erpId);
                $order->setExtensionAttributes($extensionAttributes);
            }
        }

        return $searchResults;
    }

    /**
     * Get extension attributes or create new object if attributes does not exist
     *
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
