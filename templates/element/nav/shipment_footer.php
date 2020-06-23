<?php
use Cake\Core\Configure;

$navbarInverse = !Configure::read('navbarInverse') ? '' : ' navbar-inverse';

?>
<div class="navbar fixed-bottom navbar-light bg-light<?=$navbarInverse; ?>">
    <div class="row">
        <div class="col text-center">
            <button type="submit" class="col-lg-offset-5 btn btn-primary navbar-btn">Submit</button>
        </div>
    </div>
</div>