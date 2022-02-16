<?php
declare(strict_types=1);

namespace VConnect\Erp\Api;

interface AddErpIdInterface
{
    /**
     * @param int $customerId
     * @param string $externalId
     * @return void
     */
    public function addId(int $customerId, string $externalId): void;
}
