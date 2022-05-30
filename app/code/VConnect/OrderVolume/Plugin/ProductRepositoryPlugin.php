<?php
declare(strict_types=1);

namespace VConnect\OrderVolume\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductExtensionInterfaceFactory;
use Magento\Catalog\Api\Data\ProductExtensionInterface;
use Magento\Catalog\Api\Data\ProductSearchResultsInterface;

class ProductRepositoryPlugin
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
     * @param ProductRepositoryInterface $productRepository
     * @param ProductInterface $product
     * @return ProductInterface
     */
    public function afterGetById(ProductRepositoryInterface $productRepository, ProductInterface $product): ProductInterface
    {
        $customAttribute = $product->getCustomAttribute('volume');
        if (isset($customAttribute)) {
            $volume = $customAttribute->getValue();
            $extensionAttributes = $this->getExtensionAttributes($product);
            $extensionAttributes->setProductVolume($volume);
            $product->setExtensionAttributes($extensionAttributes);
        }

        return $product;
    }

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param ProductInterface $product
     * @return ProductInterface
     */
    public function afterGet(ProductRepositoryInterface $productRepository, ProductInterface $product): ProductInterface
    {
        $customAttribute = $product->getCustomAttribute('volume');
        if (isset($customAttribute)) {
            $volume = $customAttribute->getValue();
            $extensionAttributes = $this->getExtensionAttributes($product);
            $extensionAttributes->setProductVolume($volume);
            $product->setExtensionAttributes($extensionAttributes);
        }

        return $product;
    }

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param ProductSearchResultsInterface $searchResults
     * @return ProductSearchResultsInterface
     */
    public function afterGetList(
        ProductRepositoryInterface $productRepository,
        ProductSearchResultsInterface $searchResults
    ): ProductSearchResultsInterface
    {
        foreach ($searchResults->getItems() as $product) {
            $customAttribute = $product->getCustomAttribute('volume');
            if (isset($customAttribute)) {
                $volume = $customAttribute->getValue();
                $extensionAttributes = $this->getExtensionAttributes($product);
                $extensionAttributes->setProductVolume($volume);
                $product->setExtensionAttributes($extensionAttributes);
            }
        }

        return $searchResults;
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
