<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventoryStatus Entity
 *
 * @property int $id
 * @property int $perms
 * @property string $name
 * @property string $comment
 * @property bool|null $allow_bulk_status_change
 *
 * @property \App\Model\Entity\Label[] $labels
 * @property \App\Model\Entity\Pallet[] $pallets
 * @property \App\Model\Entity\ProductType[] $product_types
 */
class InventoryStatus extends Entity
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
        'perms' => true,
        'name' => true,
        'comment' => true,
        'allow_bulk_status_change' => true,
        'labels' => true,
        'pallets' => true,
        'product_types' => true,
    ];
}
