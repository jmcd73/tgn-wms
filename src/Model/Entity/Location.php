<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Location Entity
 *
 * @property int $id
 * @property string $location
 * @property int $pallet_capacity
 * @property bool $is_hidden
 * @property string $description
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $product_type_id
 *
 * @property \App\Model\Entity\ProductType[] $product_types
  * @property \App\Model\Entity\Pallet[] $pallets
 */
class Location extends Entity
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
        'location' => true,
        'pallet_capacity' => true,
        'is_hidden' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'product_type_id' => true,
        'product_types' => true,
        'labels' => true,
        'pallets' => true,
    ];
}
