<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels\Glabel;

class GlabelsTemplate
{
    public $file_path = '';
    public $image = '';
    public $details = '';

    public function __construct(string $template_path, string $template_image, array $template_details)
    {
        $this->details = $template_details;
        $this->image = $template_image;
        $this->file_path = $template_path;
    }
}