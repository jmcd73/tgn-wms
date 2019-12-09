<?php

App::uses('AppModel', 'Model');

/**
 * Menu Model
 *
 * @property Menu $ParentMenu
 * @property Menu $ChildMenu
 */
class Menu extends AppModel
{
    /**
     * Behaviors
     *
     * @var array
     */
    public $actsAs = [
        'Tree'
    ];
    /**
     * @var string
     */
    public $displayField = 'name';

    /**
     * afterFind
     * @param array $results Results array
     * @param bool $primary Is this the primary model or being call from another
     * @return array
     */
    public function afterFind($results, $primary = false)
    {
        if ($primary) {
            return $results;
        }
        foreach ($results as $key => $val) {
            if (isset($val[$this->alias]['id'])) {
                $id = $val[$this->alias]['id'];
                $results[$key][$this->alias]['full_path'] = $this->fmtReasonCode($id);
                //$this->fmtReasonCode(  );
            }
        }

        return $results;
    }

    /**
     * @return mixed
     */
    public function findStacked()
    {
        $ret = $this->find('list', ['order' => $this->alias . ".lft"]);
        foreach ($ret as $key => $value) {
            $ret[$key] = $this->fmtReasonCode($key);
        }

        return $ret;
    }

    /**
     * @param int $id ID of Reason Code
     * @return mixed
     */
    public function fmtReasonCode($id = null)
    {
        $slug = '';
        $items = $this->getPath($id);
        $itemCount = count($items);
        $i = 0;
        foreach ($items as $rc) {
            if (++$i === $itemCount) {
                $slug .= $rc[$this->alias]['name'] . ' (' . $rc[$this->alias]['description'] . ')';
            } else {
                $slug .= $rc[$this->alias]['name'] . ' - ';
            }
        }
        // lop off traling separator

        return $slug;
    }

    /**
     * @var array
     */
    public $belongsTo = [
        'ParentMenu' => [
            'className' => 'Menu',
            'foreignKey' => 'parent_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = [
        'ChildMenu' => [
            'className' => 'Menu',
            'foreignKey' => 'parent_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => ['lft' => "ASC"],
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ]
    ];
}
