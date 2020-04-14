<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductType Entity
 *
 * @property int $id
 * @property int|null $inventory_status_id
 * @property int|null $location_id
 * @property string $name
 * @property string $storage_temperature
 * @property string $code_regex
 * @property string $code_regex_description
 * @property bool|null $active
 * @property int|null $next_serial_number
 * @property string|null $serial_number_format
 * @property bool|null $enable_pick_app
 *
 * @property \App\Model\Entity\InventoryStatus $inventory_status
 * @property \App\Model\Entity\Location[] $locations
 * @property \App\Model\Entity\Item[] $items
 * @property \App\Model\Entity\Label[] $labels
 * @property \App\Model\Entity\Pallet[] $pallets
 * @property \App\Model\Entity\ProductionLine[] $production_lines
 * @property \App\Model\Entity\Shift[] $shifts
 * @property \App\Model\Entity\Shipment[] $shipments
 */
class ProductType extends Entity
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
        'inventory_status_id' => true,
        'location_id' => true,
        'name' => true,
        'storage_temperature' => true,
        'code_regex' => true,
        'code_regex_description' => true,
        'active' => true,
        'next_serial_number' => true,
        'serial_number_format' => true,
        'enable_pick_app' => true,
        'inventory_status' => true,
        'locations' => true,
        'items' => true,
        'labels' => true,
        'pallets' => true,
        'production_lines' => true,
        'shifts' => true,
        'shipments' => true,
    ];
}