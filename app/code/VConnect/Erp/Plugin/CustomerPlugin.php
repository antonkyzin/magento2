<?php
declare(strict_types=1);

namespace VConnect\Erp\Plugin;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Api\SearchResults;

class CustomerPlugin
{
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
            $extensionAttributes = $customer->getExtensionAttributes();
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
            $extensionAttributes = $customer->getExtensionAttributes();
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
                $extensionAttributes = $customer->getExtensionAttributes();
                $extensionAttributes->setExtensionErpId($erpId);
                $customer->setExtensionAttributes($extensionAttributes);
            }
        }

        return $searchResults;
    }
}
