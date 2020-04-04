<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Menu Entity
 *
 * @property int $id
 * @property bool $active
 * @property bool $divider
 * @property bool $header
 * @property bool $admin_menu
 * @property string|null $name
 * @property string|null $description
 * @property string|null $url
 * @property string|null $options
 * @property string|null $title
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rght
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string $bs_url
 * @property string $extra_args
 *
 * @property \App\Model\Entity\Menu $parent_menu
 * @property \App\Model\Entity\Menu[] $child_menus
 */
class Menu extends Entity
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
        'divider' => true,
        'header' => true,
        'admin_menu' => true,
        'name' => true,
        'description' => true,
        'url' => true,
        'options' => true,
        'title' => true,
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'modified' => true,
        'created' => true,
        'bs_url' => true,
        'extra_args' => true,
        'parent_menu' => true,
        'child_menus' => true,
    ];
}
