<?php
declare(strict_types=1);

namespace VConnect\OrderVolume\Plugin\Block\Adminhtml\Order\View\Items;

use Magento\Sales\Api\Data\OrderItemInterface;

class RenderVolumeInOrderViewPlugin
{
    /**
     * @param $subject
     * @param string $html
     * @param OrderItemInterface $item
     * @param string $field
     * @return string
     */
    public function afterGetColumnHtml($subject, string $html, OrderItemInterface $item, string $field): string
    {
        $volume = (float)$item->getDataByKey('volume');
        $qty = (float)$item->getQtyOrdered();
        switch ($field) {
            case 'item_volume' :
                $html = $volume;
                break;
            case 'total_volume' :
                $html = $volume * $qty;
                break;
        }

        return (string)$html;
    }
}
