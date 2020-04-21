<?php
declare(strict_types=1);

namespace App\Model\Table\Traits;

use Cake\ORM\Query;

trait UpdateCounterCacheTrait
{
    /**
     * @param null|string|array $association null - update all CounterCaches
     *                                       string - update only the CounterCache for this association
     *                                       array - update CounterCaches for the listed associations,
     *                                       update only the fields listed like ['Tags' => ['count']]
     *                                       if no $cacheFields given, to update all set the key to true
     * @param null|string|array $cacheField  null - update all fields for the CounterCache(s)
     *                                       string - update only this field for the CounterCache(s)
     *                                       array - update the given fields in the CounterCache(s),
     *                                       overwriting possible set fields from the $association array
     *
     * @param  true|false        $reset reset the values to 0, if no matching entry could be found
     * @return int               number of records updated
     * @throws \RuntimeException when the CounterCacheBehavior is not attached
     */
    public function updateCounterCache($association = null, $cacheField = null, $reset = true): int
    {
        $counterCache = $this->behaviors()->get('CounterCache');

        if (!$counterCache) {
            throw new \RuntimeException('CounterCacheBehavior is not attached.');
        }

        if (is_string($association)) {
            $association = [$association => true];
        }
        if (is_string($cacheField)) {
            $cacheField = [$cacheField];
        }

        $associations = $counterCache->getConfig();

        if ($association) {
            $associations = array_intersect_key($associations, $association);
        }

        $total_count = 0;

        foreach ($associations as $assocName => $config) {
            $assoc = $this->{$assocName};
            $foreign_key = $assoc->getForeignKey();
            $target = $assoc->getTarget();
            $conds = $assoc->getConditions();

            if ($cacheField) {
                $config = array_intersect($config, $cacheField);
            } elseif (!is_null($association) && is_array($association[$assocName])) {
                $config = array_intersect($config, $association[$assocName]);
            }

            foreach ($config as $field => $options) {
                if (is_numeric($field)) {
                    $field = $options;
                    $options = [];
                }

                if ($reset) {
                    $target->query()
                        ->update()
                        ->set($field, 0)
                        ->where($conds)
                        ->execute();
                }

                if (!isset($options['conditions'])) {
                    $options['conditions'] = [];
                }

                /**
                 * @var \Cake\ORM\Query $result Query
                 * */
                $result = $this->query()
                    ->select([$foreign_key => $foreign_key, 'count' => $this->query()->func()->count('*')])
                    ->where($options['conditions'])
                    ->group($foreign_key)
                    ->execute();

                $totalrows = $result->count();

                $rowcount = 0;
                $count = 0;
                while ($row = $result->fetch('assoc')) {
                    if ($rowcount++ > $totalrows / 100) {
                        $rowcount = 0;
                    }

                    tog(['TARGET' => $target], $field, $row['count'], [$target->getPrimaryKey() => $row[$foreign_key]] + $conds);

                    $target->query()
                        ->update()
                        ->set($field, $row['count'])
                        ->where([$target->getPrimaryKey() => $row[$foreign_key]] + $conds)
                        ->execute();
                    $count++;
                }
                $total_count += $count;
            }
        }

        return (int) $total_count;
    }
}