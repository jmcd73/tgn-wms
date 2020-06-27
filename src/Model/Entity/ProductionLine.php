<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductionLine Entity
 *
 * @property int $id
 * @property bool|null $active
 * @property int|null $printer_id
 * @property string|null $name
 * @property int|null $product_type_id
 *
 * @property \App\Model\Entity\Printer $printer
 * @property \App\Model\Entity\ProductType $product_type
  * @property \App\Model\Entity\Pallet[] $pallets
 */
class ProductionLine extends Entity
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
        'active' => true,
        'printer_id' => true,
        'name' => true,
        'product_type_id' => true,
        'printer' => true,
        'product_type' => true,
        'labels' => true,
        'pallets' => true,
    ];
}
