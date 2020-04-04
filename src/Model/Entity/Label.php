<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Label Entity
 *
 * @property int $id
 * @property int|null $production_line_id
 * @property string $description
 * @property int $item_id
 * @property string $best_before
 * @property \Cake\I18n\FrozenDate $bb_date
 * @property string $gtin14
 * @property int $qty_user_id
 * @property int $qty
 * @property string $qty_previous
 * @property \Cake\I18n\FrozenTime $qty_modified
 * @property string $pl_ref
 * @property string $sscc
 * @property string $batch
 * @property string $printer_id
 * @property \Cake\I18n\FrozenTime $print_date
 * @property \Cake\I18n\FrozenTime|null $cooldown_date
 * @property int $min_days_life
 * @property int $location_id
 * @property int $shipment_id
 * @property int $inventory_status_id
 * @property string $inventory_status_note
 * @property \Cake\I18n\FrozenTime $inventory_status_datetime
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $ship_low_date
 * @property bool $picked
 * @property int|null $product_type_id
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ProductionLine $production_line
 * @property \App\Model\Entity\Printer $printer
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Shipment $shipment
 * @property \App\Model\Entity\InventoryStatus $inventory_status
 * @property \App\Model\Entity\ProductType $product_type
 */
class Label extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'production_line_id' => true,
        'item' => true,
        'description' => true,
        'item_id' => true,
        'best_before' => true,
        'bb_date' => true,
        'gtin14' => true,
        'qty_user_id' => true,
        'qty' => true,
        'qty_previous' => true,
        'qty_modified' => true,
        'pl_ref' => true,
        'sscc' => true,
        'batch' => true,
        'printer_id' => true,
        'print_date' => true,
        'cooldown_date' => true,
        'min_days_life' => true,
        'production_line' => true,
        'location_id' => true,
        'shipment_id' => true,
        'inventory_status_id' => true,
        'inventory_status_note' => true,
        'inventory_status_datetime' => true,
        'created' => true,
        'modified' => true,
        'ship_low_date' => true,
        'picked' => true,
        'product_type_id' => true,
        'printer' => true,
        'location' => true,
        'shipment' => true,
        'inventory_status' => true,
        'product_type' => true,
    ];
}
