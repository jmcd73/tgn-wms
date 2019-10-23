<?php
App::import('Controller', 'Labels');


class UpdateMinDaysLifeShell extends AppShell {
    
    public $uses = array('App');
    
    public function main() {
        
        putenv('ENVIRONMENT=TEST');
        
        $labels = new LabelsController();
        $labels->updateMinDaysLife();
        $this->out('Hello world.');
    }
}
