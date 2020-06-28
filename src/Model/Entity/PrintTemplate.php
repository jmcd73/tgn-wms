<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PrintTemplate Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $text_template
 * @property string|null $file_template
 * @property bool|null $active
 * @property int|null $is_file_template
 * @property string|null $controller_action
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $example_image
 * @property string|null $file_template_type
 * @property int|null $file_template_size
 * @property int|null $example_image_size
 * @property string|null $example_image_type
 * @property bool|null $show_in_label_chooser
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rght
 * @property string|null $replace_tokens
 *
 * @property \App\Model\Entity\PrintTemplate $parent_print_template
 * @property \App\Model\Entity\Item[] $items
 * @property \App\Model\Entity\PrintTemplate[] $child_print_templates
 */
class PrintTemplate extends Entity
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
        'description' => true,
        'text_template' => true,
        'file_template' => true,
        'active' => true,
        'is_file_template' => true,
        'controller_action' => true,
        'created' => true,
        'modified' => true,
        'example_image' => true,
        'file_template_type' => true,
        'file_template_size' => true,
        'example_image_size' => true,
        'example_image_type' => true,
        'show_in_label_chooser' => true,
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'replace_tokens' => true,
        'parent_print_template' => true,
        'items' => true,
        'child_print_templates' => true,
        'glabels_copies' => true,
        'print_class' => true,
        'send_email' => true,
    ];
}