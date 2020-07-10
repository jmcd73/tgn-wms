<?php

namespace App\Lib\Utility;


trait PalletExistsTrait {
    public function checkFileExists($outputPath, $fileName): bool
    {
        $fullPath = WWW_ROOT . $outputPath . DS . $fileName;
        return is_file($fullPath);
    }
}