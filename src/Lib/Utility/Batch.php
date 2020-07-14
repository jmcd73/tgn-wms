<?php

declare(strict_types=1);


namespace App\Lib\Utility;
use Cake\I18n\FrozenTime;
use Cake\Core\Configure;


class Batch {

     public function __construct()
     {
         $this->formats = Configure::read('BATCH_FORMATS');
     }

     public function getFormatList() {

        foreach($this->formats as $k => $f ) {
            $formatList[$k] = $f['description'];
        }
        return $formatList;
     }
      /**
     *  return array of batch numbers formatted for cakephp select options
     * $batch_nos = [
     *      601201 => '6012 - 01',
     *      601202 => '6012 - 02'
     *  ]
     *
     * @return array Array of batch numbers
     */
    public function getBatchNumbers($format = 'YDDDXX')
    {
        $settings = $this->formats[$format];

        return $this->$format($settings);

    }

    public function YDDDXX($settings, $batchNo): string
    {

        //for ($i = $settings['start']; $i <= $settings['end']; $i++) {
        //    $batch_nos[$batch_prefix . sprintf('%02d', $i)] = $batch_prefix . ' - ' . sprintf('%02d', $i);
        //}

        return $this->getYDDD() . sprintf('%02d', $batchNo);
    }

    public function getYDDD(): string
    {
        $now = FrozenTime::now();
        return substr((string) $now->year, 3) . sprintf('%03d', $now->dayOfYear + 1);
    }

    public function YDDD($settings) {

        return $this->getYDDD();
    }

}