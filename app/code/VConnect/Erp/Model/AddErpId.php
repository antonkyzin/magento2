<?php
declare(strict_types=1);

namespace VConnect\Erp\Model;

use VConnect\Erp\Api\AddErpIdInterface;
use Magento\Customer\Model\ResourceModel\CustomerRepository;

class AddErpId implements AddErpIdInterface
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param int $customerId
     * @param string $externalId
     * @return void
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function addId(int $customerId, string $externalId): void
    {
        $customer = $this->customerRepository->getById($customerId);
        $customer->setCustomAttribute('erp_id', $externalId);
        $this->customerRepository->save($customer);
    }
}
