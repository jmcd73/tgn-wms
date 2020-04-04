<?php
use Cake\Core\Configure;

$navbarInverse = !Configure::read('navbarInverse') ? '' : ' navbar-inverse';

?>
<div class="navbar navbar-default navbar-fixed-bottom<?=$navbarInverse; ?>">
    <div class="container">
        <button type="submit" class="col-lg-offset-5 btn btn-primary navbar-btn">Submit</button>
    </div>
</div>