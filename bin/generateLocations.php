<?php

/**
 * CreateLocations Class
 */
class CreateLocations
{

    /**
     * Store the list of locations
     *
     * @var string
     */
    public $store = [];

    /**
     * Row Column Level Format
     * i.e. how many leading zeros
     */
    public $rclFormat = '%02d';

    /**
     * Flag to check if store needs clearing
     *
     * @var mixed
     */
    private $__clearStore = false;

    /**
     * @var string
     */
    public $csvFilename = 'locations.csv';

    /**
     * @param $locationConfig
     */
    public function createCSVLocations($locationConfig)
    {
        $csv_file = new SplFileObject($this->csvFilename, 'w');

        // create header line
        $csv_file->fputcsv(array_keys($locationConfig[0]));

        foreach ($locationConfig as $config) {
            //echo print_r($config, true);
            $locationList = $this->formatLocations($config['location']['setup']);

            // clear after each run
            $this->store = [];

            $csv = [];
            foreach ($locationList as $kll => $vll) {
                foreach ($config as $kcnf => $vcnf) {
                    if ($kcnf == 'location') {

                        $csv[$kll][$kcnf] = $vll;

                    } else {
                        $csv[$kll][$kcnf] = $vcnf;
                    }

                }
            }

            foreach ($csv as $csv_fields) {
                $csv_file->fputcsv($csv_fields);
            }
        }

        $csv_file = null;

    }

    /**
     * Recursively parse location format array
     *
     * @param $setup Setup array
     */
    public function formatLocations($setup)
    {

        foreach ($setup as $k => $v) {
            if (is_array($v)) {
                if (empty($this->store)) {
                    $this->store = $v;
                } else {
                    $this->store = $this->append($this->store, $v, $k);
                }
                $this->formatLocations($v);
            }
        }

        return $this->store;
    }

    /**
     * @param $current
     * @param $append
     * @return mixed
     */
    public function append($current, $append, $key, $options = [])
    {
        $newVals = [];
        foreach ($current as $k => $v) {
            foreach ($append as $_k => $_v) {
                if (is_numeric($_v)) {
                    $_v = sprintf($this->rclFormat, $_v);
                }
                $newVals[] = $v . $_v;
            }
        }
        return $newVals;
    }
    /**
     * @param $args
     */
    public function lg(...$args)
    {

        echo print_r($args[0], true) . "\n";

    }

}

$locationConfig = [
    [
        'location' => [
            'setup' => [
                "prefix" => ['A-'],
                'suffix' => ['DEFAULT']
            ]
        ],
        'pallet_capacity' => 999999,
        'is_hidden' => (int)false,
        'description' => 'Ambient Storage',
        'created' => date("Y-m-d H:i:s"),
        'modified' => date("Y-m-d H:i:s"),
        'product_type_id' => 1,
        'overflow' => (int)false
    ],
    [
        'location' => [
            'setup' => [
                'prefix' => ['C-'],
                'row' => ['A', 'B', 'C', 'D'],
                'column' => [1, 2, 3, 4, 5],
                'level' => [1, 2, 3, 4]
            ]
        ],
        'pallet_capacity' => 2,
        'is_hidden' => (int)false,
        'description' => 'Coolroom location',
        'created' => date("Y-m-d H:i:s"),
        'modified' => date("Y-m-d H:i:s"),
        'product_type_id' => 2,
        'overflow' => (int)false
    ],
    [
        'location' => [

            'setup' => [
                'Chilled' => ['C-'],
                'overflow' => ['Floor']
            ]
        ],
        'pallet_capacity' => 2,
        'is_hidden' => (int)false,
        'description' => 'Coolroom overflow',
        'created' => date("Y-m-d H:i:s"),
        'modified' => date("Y-m-d H:i:s"),
        'product_type_id' => 1,
        'overflow' => (int)true
    ]
];

$fl = new CreateLocations();

$fl->createCSVLocations($locationConfig);

