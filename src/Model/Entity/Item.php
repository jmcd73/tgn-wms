<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property bool $active
 * @property string $code
 * @property string $description
 * @property int $quantity
 * @property string|null $trade_unit
 * @property int $pack_size_id
 * @property int $product_type_id
 * @property string|null $consumer_unit
 * @property string|null $brand
 * @property string|null $variant
 * @property int|null $unit_net_contents
 * @property string|null $unit_of_measure
 * @property int|null $days_life
 * @property int $min_days_life
 * @property string $item_comment
 * @property int $pallet_template_id
 * @property int $carton_template_id
 * @property int|null $pallet_label_copies
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\PackSize $pack_size
 * @property \App\Model\Entity\ProductType $product_type
 * @property \App\Model\Entity\PrintTemplate $print_template
 * @property \App\Model\Entity\Carton[] $cartons
 * @property \App\Model\Entity\Label[] $labels
 * @property \App\Model\Entity\Pallet[] $pallets
 */
class Item extends Entity
{
    protected function _getFullName()
    {
        return $this->code . ' - ' . $this->description;
    }

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
        'code' => true,
        'description' => true,
        'quantity' => true,
        'trade_unit' => true,
        'pack_size_id' => true,
        'product_type_id' => true,
        'consumer_unit' => true,
        'brand' => true,
        'variant' => true,
        'unit_net_contents' => true,
        'unit_of_measure' => true,
        'days_life' => true,
        'min_days_life' => true,
        'item_comment' => true,
        'pallet_template_id' => true,
        'carton_template_id' => true,
        'pallet_label_copies' => true,
        'created' => true,
        'modified' => true,
        'pack_size' => true,
        'product_type' => true,
        'print_template' => true,
        'cartons' => true,
        'labels' => true,
        'pallets' => true,
    ];
}