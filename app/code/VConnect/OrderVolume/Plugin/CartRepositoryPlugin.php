<?php
declare(strict_types=1);

namespace VConnect\OrderVolume\Plugin;

use Magento\Catalog\Api\Data\ProductExtensionInterface;
use Magento\Catalog\Api\Data\ProductExtensionInterfaceFactory;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Catalog\Api\Data\ProductInterface;

class CartRepositoryPlugin
{
    private ProductExtensionInterfaceFactory $extensionFactory;

    /**
     * @param ProductExtensionInterfaceFactory $extensionFactory
     */
    public function __construct(ProductExtensionInterfaceFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }
    /**
     * @param CartRepositoryInterface $cartRepository
     * @param CartInterface $cart
     * @return void
     */
    public function beforeSave(CartRepositoryInterface $cartRepository, CartInterface $cart): void
    {
        /**
         * @var \Magento\Quote\Model\Quote\Item $item
         */
        $items = $cart->getItemsCollection()->getItems();
        foreach ($items as $item) {
            $product = $item->getProduct();
            $extensionAttributes = $this->getExtensionAttributes($product);
            $volume = $extensionAttributes->getProductVolume();
            if (isset($volume)) {
                $item->setData('volume', $volume);
            }
        }
    }

    /**
     * @param CartRepositoryInterface $cartRepository
     * @param CartInterface $cart
     * @return CartInterface
     */
    public function afterGetActive(CartRepositoryInterface $cartRepository, CartInterface $cart): CartInterface
    {
        /**
         * @var \Magento\Quote\Model\Quote\Item $item
         */
        $items = $cart->getItemsCollection()->getItems();
        foreach ($items as $item) {
            $volume = $item->getDataByKey('volume');
            if (isset($volume)) {
                $extensionAttributes = $item->getExtensionAttributes();
                $extensionAttributes->setProductVolume($volume);
                $item->setExtensionAttributes($extensionAttributes);
            }
        }

        return $cart;
    }

    /**
     * @param ProductInterface $product
     * @return ProductExtensionInterface
     */
    public function getExtensionAttributes(ProductInterface $product): ProductExtensionInterface
    {
        $extensionAttributes = $product->getExtensionAttributes();
        if (!isset($extensionAttributes)) {
            $extensionAttributes = $this->extensionFactory->create();
        }

        return $extensionAttributes;
    }
}
