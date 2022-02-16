<?php
declare(strict_types=1);

namespace VConnect\Erp\Plugin;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;

class OrderPlugin
{
    /**
     * @param OrderRepositoryInterface $orderRepositoryInterface
     * @param OrderInterface $order
     * @return void
     */
    public function beforeSave(OrderRepositoryInterface $orderRepositoryInterface, OrderInterface $order)
    {
        $erpId = $order->getExtensionAttributes()->getExtensionErpId();
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
            $order->getExtensionAttributes()->setExtensionErpId($erpId);
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
            $externalId = $order->getDataByKey('extension_erp_id');
            if (isset($externalId)) {
                $extensionAttributes = $order->getExtensionAttributes();
                $extensionAttributes->setExtensionErpId($externalId);
                $order->setExtensionAttributes($extensionAttributes);
            }
        }

        return $searchResults;
    }
}
