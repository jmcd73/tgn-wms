<?php

declare(strict_types=1);

namespace App\Lib\PrintLabels\Glabel;

use App\Lib\Exception\MissingConfigurationException;
use App\Lib\PrintLabels\Template;
use App\Model\Entity\PrintTemplate;
use Cake\Core\Configure;
use SimpleXMLElement;
use App\Lib\Utility\SettingsTrait;

use InvalidArgumentException;

/**
 * GlabelsProject
 *
 * @package App\Lib\PrintLabels\Glabel
 * @param \Cake\Datasource\EntityInterface $template
 */
class GlabelsProject extends Template
{
    use SettingsTrait;
    private $mergePath = '/dev/stdin';
    public $filePath = '';
    private $companyName = '';

    public function __construct(PrintTemplate $template, string $glabelsRoot)
    {
        parent::__construct($template, $glabelsRoot);

        $this->companyName = $this->getSetting("COMPANY_NAME");

        $this->filePath = $this->getFilePath($template, $glabelsRoot);

        $this->editGlabelsProject($this->filePath, $this->mergePath);
    }

    public function editGlabelsProject($filePath, $mergePath)
    {
        $contents = $this->getProjectContents($filePath);
        [$contents, $replaceCount] = $this->replaceCompanyName($contents);
        [$glabelsDocument, $mergeCount] = $this->setMergePath($contents, $mergePath);
        if ($replaceCount > 0 | $mergeCount > 0) {
            $this->saveProject($filePath, $glabelsDocument);
        }
    }

    public function getFilePath(PrintTemplate $template, $glabelsRoot)
    {
        $filePath = WWW_ROOT . $glabelsRoot . DS . $template->file_template;

        if (is_file($filePath)) {
            return $filePath;
        }

        throw new MissingConfigurationException(__('Glabels Project File missing from {0}', $filePath));
    }

    /**
     * Opens both XML and Gzipped glabels files
     * Edits the <Merge src="" /> attribute to make it
     * /dev/stdin
     *
     * @param  mixed      $projectFile Full path to glabels file
     * @param  mixed|null $mergePath   /dev/stdin
     * @return void
     */
    public function setMergePath($contents, $mergePath): array
    {
        $count = 0;

        $glabelsDocument = simplexml_load_string($contents);

        if ($glabelsDocument->Merge['src'] != $mergePath) {
            $glabelsDocument->Merge['src'] = $mergePath;
            $count = 1;
        }

        return [$glabelsDocument, $count];
    }

    public function saveProject($projectFile, SimpleXMLElement $glabelsDocument): bool
    {
        return $glabelsDocument->asXML($projectFile);
    }

    public function getProjectContents($projectFile): string
    {
        $fp = gzopen($projectFile, 'r');
        $contents = gzread($fp, 1000000); // 1mb
        gzclose($fp);

        return $contents;
    }

    public function replaceCompanyName($haystack): array
    {
        $replaced = str_replace('{{COMPANY_NAME}}', $this->companyName, $haystack, $count);
        return [$replaced, $count];
    }
}
