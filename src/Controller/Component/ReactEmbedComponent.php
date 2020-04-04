<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Filesystem\File;
use Cake\Http\Exception\NotFoundException;

class ReactEmbedComponent extends Component
{
    protected $controller = null;

    public function initialize(array $config): void
    {
        parent::initialize($config);
    }

    /**
     * @param string $subFolder Subfolder webroot/shipment-app <= shipment-app is subfolder
     */
    public function getAssets($subFolder)
    {
        list($js, $css) = $this->assets($subFolder);

        return [$js, $css];
    }

    /**
     * @param string $subFolder Folder that the react app is in
     * e.g. subFolder is webroot/pick-app
     *
     * @return array
     */
    public function assets($subFolder)
    {
        $assetManifest = WWW_ROOT . DS . $subFolder . DS . 'asset-manifest.json';

        $file = new File($assetManifest);

        if (!$file->exists()) {
            throw new NotFoundException($assetManifest . ' missing');
        }

        $manifest = json_decode($file->read());

        $file->close();

        $js = [];
        $css = [];

        $prefix = DS . $subFolder;

        foreach ($manifest->files as $key => $value) {
            if (preg_match('/\.js$/', $key) === 1) {
                $js[] = $prefix . $value;
            }
            if (preg_match('/\.css$/', $key) === 1) {
                $css[] = $prefix . $value;
            }
        }

        return [$js, $css];
    }
}