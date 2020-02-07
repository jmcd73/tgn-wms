<?php
/**
 * ReactEmbedComponent
 *
 */
App::uses('Component', 'Controller');
App::uses('File', 'Utility');

class ReactEmbedComponent extends Component
{
    protected $controller = null;

    public function initialize(Controller $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param string $subFolder Subfolder webroot/shipment-app <= shipment-app is subfolder
     */
    public function getAssets($subFolder)
    {
        $baseUrl = $this->baseUrl();

        list($js, $css) = $this->assets($subFolder);

        return [$js, $css, $baseUrl];
    }

    /**
     * @return mixed
     */
    public function baseUrl()
    {
        return $this->controller->request->webroot;
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