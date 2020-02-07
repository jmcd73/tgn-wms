<?php

include_once '../../app/Config/database.php';

$a = new DATABASE_CONFIG;
$b = serialize($a);

var_dump($a->tgn);