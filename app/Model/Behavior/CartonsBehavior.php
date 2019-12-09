<?php

App::uses('ModelBehavior', 'Model');

class CartonsBehavior extends ModelBehavior
{

    // paginate and paginateCount implemented on a behavior.
    /**
     * @param Model $model
     * @param $conditions
     * @param $fields
     * @param $order
     * @param $limit
     * @param $page
     * @param $recursive
     * @param array $extra
     */
    public function paginate(Model $model, $conditions, $fields, $order, $limit,
        $page = 1, $recursive = null, $extra = []) {
        $joins = $extra['joins'];
        $contain = $extra['contain'];
        $having = $extra['having'];
        $group = $extra['group'];

        $results = $model->find(
            'all',
            compact('conditions', 'fields', 'order', 'limit', 'having', 'page', 'recursive', 'group', 'joins', 'contain')
        );
        //   debug(Hash::extract($results, '{n}.{n}'));
        $results = Hash::map($results, "{n}", function ($result) {
            $cartonRecordCount = $result[0];
            unset($result[0]);
            $result['cartonRecordCount'] = $cartonRecordCount['cartonRecordCount'];

            return $result;
        });

        return $results;
    }

    /**
     * @param Model $model
     * @param $conditions
     * @param null $recursive
     * @param array $extra
     */
    public function paginateCount(Model $model, $conditions = null, $recursive = 0,
        $extra = []) {

        $joins = $extra['joins'];
        $contain = $extra['contain'];
        $having = $extra['having'];
        $group = $extra['group'];
        $fields = $extra['countFields'];

        $results = $model->find(
            'all',
            compact('conditions', 'having', 'fields', 'recursive', 'group', 'joins', 'contain')
        );

        return count($results);

    }

}