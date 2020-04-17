<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels\Glabel;

use App\Lib\Exception\MissingConfigurationException;
use App\Lib\PrintLabels\Template;
use App\Model\Entity\PrintTemplate;

/**
 * GlabelsProject
 *
 * @package App\Lib\PrintLabels\Glabel
 * @param \Cake\Datasource\EntityInterface $template
 */
class GlabelsProject extends Template
{
    public $mergePath = '/dev/stdin';
    public $projectXML = '';
    public $file_path = '';

    public function __construct(PrintTemplate $template, string $glabelsRoot)
    {
        parent::__construct($template, $glabelsRoot);

        $this->file_path = $this->getFilePath($template, $glabelsRoot);
        $this->setMergePath($this->file_path);
    }

    public function getFilePath($template, $glabelsRoot)
    {
        $filePath = WWW_ROOT . $glabelsRoot . DS . $template->file_template;

        if (is_file($filePath)) {
            return $filePath;
        }

        throw new MissingConfigurationException(__('Glabels Project File missing from {0}', $filePath));
    }

    public function setMergePath($projectFile, $mergePath = null)
    {
        $mergePath = $mergePath ?? $this->mergePath;

        if (file_exists($projectFile)) {
            $glabelsDocument = simplexml_load_file($projectFile);
            if ($glabelsDocument->Merge['src'] != $mergePath) {
                tog('Updating merge path on ' . $projectFile);
                $glabelsDocument->Merge['src'] = $mergePath;
                $glabelsDocument->asXML($projectFile);
            }
        }
    }
}