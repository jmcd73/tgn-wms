<?php

// merge test

$requestedLabels = [

    [
        'shipment_id' => 7,
        'id' => 7
    ],

    [
        'shipment_id' => 7,
        'id' => 8
    ],

    [
        'shipment_id' => 7,
        'id' => 9
    ],

    [
        'shipment_id' => 7,
        'id' => 10
    ]

];

$previousLabels =
    [

    [
        'id' => 7,
        'shipment_id' => 0,
        'picked' => 0
    ],

    [
        'id' => 8,
        'shipment_id' => 0,
        'picked' => 0
    ],

    [
        'id' => 9,
        'shipment_id' => 0,
        'picked' => 0
    ],

    [
        'id' => 10,
        'shipment_id' => 0,
        'picked' => 0
    ],

    [
        'id' => 13,
        'shipment_id' => 0,
        'picked' => 0
    ],

    [
        'id' => 14,
        'shipment_id' => 0,
        'picked' => 0
    ]

];

/**
 * @param $arr
 */
function lg(...$arr)
{
    echo print_r($arr, true) . "\n";
}
lg($previousLabels);
lg($requestedLabels);

$requestedIds = array_map(function ($val) {
    lg('val', $val);
    return $val['id'];
}, $requestedLabels);

lg('rid', $requestedIds);

$previousWithoutRequested = array_filter(
    $previousLabels,
    function ($val) use ($requestedIds) {
        return (!in_array($val['id'], $requestedIds));
    }
);

lg('ret', $ret);

$currentArray = array_merge($previousWithoutRequested, $requestedLabels);

$picked0 = array_map(
    function ($val) {
        $val['picked'] = 0;
        return $val;
    },
    $currentArray
);

lg('merged', $currentArray);
lg('picked', $picked0);
