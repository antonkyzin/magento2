<?php
declare(strict_types=1);

namespace VConnect\Erp\Plugin;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Customer\Api\Data\CustomerExtensionFactory;
use Magento\Customer\Api\Data\CustomerExtensionInterface;

class CustomerPlugin
{
    private CustomerExtensionFactory $extensionFactory;

    /**
     * @param CustomerExtensionFactory $extensionFactory
     */
    public function __construct(CustomerExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerInterface $customer
     * @return CustomerInterface
     */
    public function afterGetById(CustomerRepositoryInterface $customerRepository, CustomerInterface $customer): CustomerInterface
    {
        $customAttribute = $customer->getCustomAttribute('erp_id');
        if (isset($customAttribute)) {
            $erpId = $customAttribute->getValue();
            $extensionAttributes = $this->getExtensionAttributes($customer);
            $extensionAttributes->setExtensionErpId($erpId);
            $customer->setExtensionAttributes($extensionAttributes);
        }

        return $customer;
    }

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerInterface $customer
     * @return CustomerInterface
     */
    public function afterGet(CustomerRepositoryInterface $customerRepository, CustomerInterface $customer): CustomerInterface
    {
        $customAttribute = $customer->getCustomAttribute('erp_id');
        if (isset($customAttribute)) {
            $erpId = $customAttribute->getValue();
            $extensionAttributes = $this->getExtensionAttributes($customer);
            $extensionAttributes->setExtensionErpId($erpId);
            $customer->setExtensionAttributes($extensionAttributes);
        }

        return $customer;
    }

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param SearchResults $searchResults
     * @return SearchResults
     */
    public function afterGetList(CustomerRepositoryInterface $customerRepository, SearchResults $searchResults): SearchResults
    {
        foreach ($searchResults->getItems() as $customer) {
            $customAttribute = $customer->getCustomAttribute('erp_id');
            if (isset($customAttribute)) {
                $erpId = $customAttribute->getValue();
                $extensionAttributes = $this->getExtensionAttributes($customer);
                $extensionAttributes->setExtensionErpId($erpId);
                $customer->setExtensionAttributes($extensionAttributes);
            }
        }

        return $searchResults;
    }

    /**
     * Get extension attributes or create new object if attributes does not exist
     *
     * @param CustomerInterface $customer
     * @return CustomerExtensionInterface
     */
    public function getExtensionAttributes(CustomerInterface $customer): CustomerExtensionInterface
    {
        $extensionAttributes = $customer->getExtensionAttributes();
        if (!isset($extensionAttributes)) {
            $extensionAttributes = $this->extensionFactory->create();
        }

        return $extensionAttributes;
    }

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerInterface $customer
     * @return void
     */
    public function beforeSave(CustomerRepositoryInterface $customerRepository, CustomerInterface $customer)
    {
        $erpId = $this->getExtensionAttributes($customer)->getExtensionErpId();
        if ($erpId) {
            $customer->setCustomAttribute('erp_id', $erpId);
        }
    }
}
