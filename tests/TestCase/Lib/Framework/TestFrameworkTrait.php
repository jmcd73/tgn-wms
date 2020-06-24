<?php

namespace App\Test\TestCase\Lib\Framework;

use Cake\Filesystem\File;
use Cake\Filesystem\Folder;

trait TestFrameworkTrait
{

    protected $outputDir = '';

    public function __construct() {
        $this->outputDir = '/var/www/' . getenv('WEB_DIR') . '/PDF';
    }

    public function stripSpacesAndNewLines($inputString)
    {
        $patterns = ['/\s+/', '/\n/'];
        if (is_array($inputString)) {
            $inputString = implode("\n", $inputString);
        }

        return preg_replace($patterns, ' ', trim($inputString));
    }

    public function cleanUpOutputDir()
    {
        $folder = new Folder($this->outputDir);
        $files = $folder->find('.*\.pdf');

        foreach ($files as $file) {
            $file = new File($folder->pwd() . DS . $file);
            $file->delete();
        }
    }

    public function checkForPdfPrintOutput($outputDir, $filePattern)
    {
        $dir = new Folder($outputDir);
        $dateTimeStamp = date('YmdHi');
        $numChecks = 100;
        $i = 0;
        do {
            $files = $dir->find($dateTimeStamp . $filePattern);

            // if you get to 100 check exit or when you see the file
            $keepLooping = count($files) === 0 && $i++ < $numChecks;
            // pause .1 second
            usleep(10000);
        } while ($keepLooping);

        // wait to write out file after seeing it
        sleep(1);

        return $outputDir . DS . $files[0];
    }

    public function getContents($outputFile)
    {
        $cmd = 'pdftotext ' . $outputFile . ' -';

        exec($cmd, $outputContents);

        return $outputContents;
    }
}