<?php
declare(strict_types=1);

namespace App\Lib\Utility;
use Cake\I18n\FrozenTime;

trait FormatDateTrait {

     /**
     * FormatLabelDates given a dateString and an array of dateFormats as follows
     *
     * [
     *     'bb_date' => 'dd/mm/yy',
     *     'mysl_date' => 'yyyy-MM-dd'
     * ]
     *
     * returns the dates with the Initial keys e.g.
     * [
     *     'bb_date' => '31/01/73',
     *     'mysql_date' => '1973-01-31'
     * ]
     *
     * @param  \Cake\I18n\FrozenTime $dateObject  The date as a string
     * @param  array                 $dateFormats As above example
     * @return array                 of date strings
     */
    public function formatLabelDates(FrozenTime $dateObject): array
    {
        $dates = [];

        $dateFormats = $this->getConfig('labelDateFormats');

        foreach ($dateFormats as $k => $v) {
            $dates[$k] = $dateObject->format($v);
        }

        return $dates;
    }

}