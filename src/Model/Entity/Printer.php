<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Log\LogTrait;
use Cake\ORM\Entity;

/**
 * Printer Entity
 *
 * @property int $id
 * @property bool|null $active
 * @property string|null $name
 * @property string|null $options
 * @property string|null $queue_name
 * @property string|null $set_as_default_on_these_actions
 *
 * @property \App\Model\Entity\Label[] $labels
 * @property \App\Model\Entity\Pallet[] $pallets
 * @property \App\Model\Entity\ProductionLine[] $production_lines
 */
class Printer extends Entity
{
    use LogTrait;
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
        'name' => true,
        'options' => true,
        'queue_name' => true,
        'set_as_default_on_these_actions' => true,
        'labels' => true,
        'pallets' => true,
        'production_lines' => true,
    ];

    protected function _getArrayOfActions()
    {
        $this->log(print_r($this->set_as_default_on_these_actions, true));
        return explode("\n", $this->set_as_default_on_these_actions);
    }
}