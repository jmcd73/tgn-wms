<?php
/**
 * ReactEmbedComponent
 *
 */
App::uses('Component', 'Controller');
App::uses('File', 'Utility');

class ReactEmbedComponent extends Component
{

    /**
     * @param $subFolder
     * @param $classInstance
     */
    public function getAssets($subFolder, $classInstance)
    {
        $baseUrl = $this->baseUrl($classInstance);
        list($js, $css) = $this->assets($subFolder);
        return [$js, $css, $baseUrl];
    }

    /**
     * @param $classInstance
     * @return mixed
     */
    public function baseUrl($classInstance)
    {
        $baseUrl = $classInstance->request->webroot;
        return $baseUrl;
    }

    /**
     * @param string $subFolder Folder that the react app is in
     * e.g. subFolder is webroot/pick-app
     *
     * @return array
     */
    public function assets($subFolder)
    {
        $filePath = WWW_ROOT . '/' . $subFolder . '/asset-manifest.json';
        $file = new File($filePath);

        if (!$file->exists()) {
            throw new NotFoundException($filePath . ' missing');
        }
        $manifest = json_decode($file->read());
        $file->close();

        $js = [];
        $css = [];

        $prefix = '/' . $subFolder;
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
