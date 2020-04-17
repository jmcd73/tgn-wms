<?php

$gzipped = '150x200-shipping-labels-generic.glabels';
$notgz = '200x150-glabels-sample.glabels';

foreach ([$gzipped, $notgz] as $file) {
    $fp = gzopen($file, 'r');

    $contents = gzread($fp, 10000);

    $xml = simplexml_load_string($contents);
    echo print_r($xml->asXML(), true);
}