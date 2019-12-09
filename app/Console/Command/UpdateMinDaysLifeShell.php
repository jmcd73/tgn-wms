<?php
App::import('Controller', 'Labels');


class UpdateMinDaysLifeShell extends AppShell {

    public $uses = array('App');

    public function main() {

        putenv('ENVIRONMENT=TEST');

        $pallets = new PalletsController();
        $pallets->updateMinDaysLife();
        $this->out('Hello world.');
    }
}
