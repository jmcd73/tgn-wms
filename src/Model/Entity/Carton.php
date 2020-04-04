<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Carton Entity
 *
 * @property int $id
 * @property int|null $pallet_id
 * @property int|null $count
 * @property \Cake\I18n\FrozenDate|null $best_before
 * @property \Cake\I18n\FrozenDate|null $production_date
 * @property int|null $item_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $user_id
 *
 * @property \App\Model\Entity\Pallet $pallet
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\User $user
 */
class Carton extends Entity
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
        'pallet_id' => true,
        'count' => true,
        'best_before' => true,
        'production_date' => true,
        'item_id' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'pallet' => true,
        'item' => true,
        'user' => true,
    ];
}
