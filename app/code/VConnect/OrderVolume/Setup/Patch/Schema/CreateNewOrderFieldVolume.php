<?php
declare(strict_types=1);

namespace VConnect\OrderVolume\Setup\Patch\Schema;

use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class CreateNewOrderFieldVolume implements SchemaPatchInterface

{
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }


    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @return void
     */
    public function apply(): void
    {
        $data = [
            'type' => 'decimal',
            'label' => 'Order volume',
            'comment'  => 'Order volume',
            'default' => 1.00,
            'visible' => true,
            'required' => false,
            'grid' => true
        ];
        $this->moduleDataSetup->startSetup();
        $this->moduleDataSetup->getConnection()->addColumn(
            $this->moduleDataSetup->getTable('sales_order'),
            'volume',
            $data
        );
        $this->moduleDataSetup->getConnection()->addColumn(
            $this->moduleDataSetup->getTable('sales_order_grid'),
            'volume',
            $data
        );
        $this->moduleDataSetup->endSetup();
    }
}
