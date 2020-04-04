<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Shipment Entity
 *
 * @property int $id
 * @property int $operator_id
 * @property int $truck_registration_id
 * @property string $shipper
 * @property string $con_note
 * @property string $shipment_type
 * @property int|null $product_type_id
 * @property string $destination
 * @property int $pallet_count
 * @property bool $shipped
 * @property \Cake\I18n\FrozenTime|null $time_start
 * @property \Cake\I18n\FrozenTime|null $time_finish
 * @property int|null $time_total
 * @property int|null $truck_temp
 * @property int|null $dock_temp
 * @property int|null $product_temp
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Operator $operator
 * @property \App\Model\Entity\TruckRegistration $truck_registration
 * @property \App\Model\Entity\ProductType $product_type
 * @property \App\Model\Entity\Label[] $labels
 * @property \App\Model\Entity\Pallet[] $pallets
 */
class Shipment extends Entity
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
        'operator_id' => true,
        'truck_registration_id' => true,
        'shipper' => true,
        'con_note' => true,
        'shipment_type' => true,
        'product_type_id' => true,
        'destination' => true,
        'pallet_count' => true,
        'shipped' => true,
        'time_start' => true,
        'time_finish' => true,
        'time_total' => true,
        'truck_temp' => true,
        'dock_temp' => true,
        'product_temp' => true,
        'created' => true,
        'modified' => true,
        'operator' => true,
        'truck_registration' => true,
        'product_type' => true,
        'labels' => true,
        'pallets' => true,
    ];
}
