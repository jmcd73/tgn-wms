<?php
declare(strict_types=1);

namespace App\Lib\PrintLabels;

use App\Model\Entity\PrintTemplate;

class Template
{
    public $image = '';
    public $details = '';

    public function __construct(PrintTemplate $template, string $glabelsRoot)
    {
        $this->details = $template;
        $this->print_class = $template->print_class;
        
        $this->image = DS . $glabelsRoot . DS . $template->example_image;
        // code...
    }
}