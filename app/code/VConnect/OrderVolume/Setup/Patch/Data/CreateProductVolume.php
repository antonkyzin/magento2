<?php
declare(strict_types=1);

namespace VConnect\OrderVolume\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class CreateProductVolume implements DataPatchInterface
{
    private EavSetupFactory $eavSetupFactory;
    private ModuleDataSetupInterface $setup;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $setup
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->setup = $setup;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->setup]);
        $entityType = $eavSetup->getEntityTypeId('catalog_product');

        $eavSetup->addAttribute(
            $entityType,
            'volume',
            [
                'label' => 'Volume of product',
                'group' => 'General',
                'input' => 'text',
                'type' => 'decimal',
                'source' => '',
                'required' => false,
                'visible' => true,
                'system' => false,
                'default' => '',
                'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                'user_defined' => false,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'used_in_grid' => true,
                'unique' => false,
                'frontend_class' => 'validate-number',
            ]
        );
    }
}
