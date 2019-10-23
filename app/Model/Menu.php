<?php

App::uses('AppModel', 'Model');

/**
 * Menu Model
 *
 * @property Menu $ParentMenu
 * @property Menu $ChildMenu
 */
class Menu extends AppModel {

    
    
    /**
     * Behaviors
     *
     * @var array
     */
    public $actsAs = [
        'Tree',
    ];
    public $displayField = 'name';

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public function afterFind($results, $primary = false) {

        if ($primary) {
        return $results;
 }
        foreach ($results as $key => $val) {
            if (isset($val[$this->alias]['id'])) {
                $id = $val[$this->alias]['id'];
                $results[$key][$this->alias]['full_path'] = $this->fmt_reason_code($id);
                //$this->fmt_reason_code(  );
            }
        }

        return $results;
    }

    public function return_roles(){
        return Configure::read('Users.roles');
    }
    public function find_stacked()
    {
        $ret = $this->find('list', ['order' => $this->alias . ".lft"]);
        foreach($ret as $key => $value){
            
            $ret[$key] = $this->fmt_reason_code($key);
            
        }
        return $ret;
    }
    public function fmt_reason_code($id = null) {
            $slug = '';
            $items = $this->getPath($id);
            $itemCount = count($items);
            $i = 0;
            foreach ( $items as $rc) {
                
                if(++$i === $itemCount) {
                    $slug .= $rc[$this->alias]['name'] . ' (' . $rc[$this->alias]['description']  . ')';
                } else {
                    $slug .= $rc[$this->alias]['name'] . ' - ';
                }
            }
            // lop off traling separator
            return $slug;
    }

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
