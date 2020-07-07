<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Cake\ORM\TableRegistry;

/**
 * Pallets seed.
 */
class PalletsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {

        $data = [];

        $table = $this->table('pallets');

        $this->clearPdfOutpuDir();
        $table->truncate();

        $table->insert($data)->save();
    
    }

    public function clearPdfOutpuDir()
    {
        $settings = TableRegistry::getTableLocator()->get("Settings");

        $setting = $settings->find()->where(['name' => 'LABEL_OUTPUT_PATH'])->first();

        # returns false if it doesn't exist
        # or path if does
        $outputDir = realpath(__DIR__ . '/../../webroot/' . $setting->setting);

        if($outputDir) {
            foreach( new DirectoryIterator($outputDir) as $fileInfo ) {
                if($fileInfo->isDot()) continue;
                unlink($fileInfo->getPathname());
            }    
        } else {
            throw new Exception("You need to create the " . $setting->setting . ' directory in webroot and make www-data owner');
        }

        # code...
    }
}
