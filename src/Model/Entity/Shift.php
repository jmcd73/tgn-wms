<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Shift Entity
 *
 * @property int $id
 * @property string $name
 * @property int $shift_minutes
 * @property string $comment
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $active
 * @property bool $for_prod_dt
 * @property \Cake\I18n\FrozenTime $start_time
 * @property \Cake\I18n\FrozenTime $stop_time
 * @property int $product_type_id
 *
 * @property \App\Model\Entity\ProductType $product_type
 */
class Shift extends Entity
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
        'name' => true,
        'shift_minutes' => true,
        'comment' => true,
        'created' => true,
        'modified' => true,
        'active' => true,
        'for_prod_dt' => true,
        'start_time' => true,
        'stop_time' => true,
        'product_type_id' => true,
        'product_type' => true,
    ];
}
