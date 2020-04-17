<?php

namespace App\Lib\PrintLabels;

use App\Lib\Exception\GlabelsException;
use App\Lib\PrintLabels\Glabel\GlabelsProject;
use Cake\Core\Configure;
use Cake\Filesystem\File;
use Cake\I18n\FrozenDate;

/**
 * Label base class
 */
class Label
{
    use PrinterListTrait;

    /**
     * When a multipage print contains the same content on each page
     * this is set to false and then the glabelPrintCopies value is
     * passed to the lpr command. e.g lpr -# 45 {...}
     *
     * When a multipage print contains variable content such as sequence
     * number then this is set to true and glabelPrintCopies is set to
     * 1 and lpr recieves lpr -# 1 {...}
     *
     * @var bool $variablePages
     */
    protected $variablePages = false;

    public $printerName = '';
    public $printerQueue = '';
    public $options = '';
    public $action = '';

    /**
     * @var int $glabelPrintCopies
     */
    protected $glabelPrintCopies = 0;
    /**
     * @var bool
     */
    protected $glabelsMergeCSV = false;

    /**
     * @var string
     */
    private $glabelsTemplate = '';
    /**
     * @var string
     */
    protected $outFile = 'output.pdf';
    /**
     * @var string
     */
    protected $printContent = '';
    /**
     * @var array
     */
    protected $printContentArray = [];
    /**
     * @var mixed
     */
    protected $cwd = null;
    /**
     * @var string
     */
    protected $jobId = '';

    protected $reference = '';

    protected $glabelsBatch = '';

    public function __construct($action)
    {
        $this->glabelsBatch = Configure::read('GLABELS_BATCH_BINARY');
        $this->action = $action;
        $this->setJobId($action);
        $this->setCwd(TMP);
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function getVariablePages()
    {
        return $this->variablePages;
    }

    /**
     * gets the current working directory
     *
     * @return string
     */
    public function getCwd()
    {
        return $this->cwd;
    }

    /**
     * Sets the current working directory for the print process
     *
     * @param  string $cwd usually TMP is passed in
     * @return void
     */
    public function setCwd($cwd)
    {
        $this->cwd = $cwd;
    }

    /**
     * @param  array $printArray an array
     * @return void
     */
    public function setPrintContentArray($printArray)
    {
        $this->printContentArray = $printArray;
    }

    /**
     * @param  string $value Get an array value when passed a key
     * @return mixed
     */
    public function getPrintContentArrayValue($value)
    {
        if (isset($this->printContentArray[$value])) {
            return $this->printContentArray[$value];
        } else {
            throw new GlabelsException(
                'value: ' . $value . ' does not exist in ' .
                print_r($this->printContentArray, true)
            );
        }
    }

    /**
     * @param  string $template Template from config
     * @return void
     */
    private function setGlabelsTemplate($template)
    {
        $this->glabelsTemplate = realpath($template->file_path);
    }

    public function formatLocalDate($date)
    {
        return FrozenDate::parse($date)->format(Configure::read('dateFormat'));
    }

    /**
     * Formats a date as YYYYMMDDHHMMSS
     * @return string
     */
    protected function formatDate()
    {
        return date('YmdHis');
    }

    /**
     * @return mixed
     */
    public function getGlabelsTemplate()
    {
        return $this->glabelsTemplate;
    }

    /**
     * @return mixed
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * @param  string $actionOrReference pass in the controller action e.g. cartonPrint or a pallet reference e.g. 0023456
     * @return string something like 201912021219-B0232232
     */
    public function setJobId($actionOrReference = '')
    {
        $fmtDate = $this->formatDate();

        if ($actionOrReference !== '') {
            $actionOrReference = '-' . $actionOrReference;
        }

        return $this->jobId = $fmtDate . $actionOrReference;
    }

    /**
     * Sets the output file name and path
     * @param  string $rootDir The root directory usually TMP/file.pdf
     * @return void
     */
    public function setPdfOutFile($rootDir)
    {
        $this->outFile = tempnam($rootDir, 'glabels');
    }

    /**
     * @return mixed
     */
    public function getPdfOutFile()
    {
        return $this->outFile;
    }

    /**
     * @param  mixed $content Print Content
     * @return void
     */
    protected function setPrintContent($content)
    {
        $this->printContent = $content;
    }

    /**
     * @param  array  $input     Array to convert to CSV
     * @param  string $delimiter Typically a comma
     * @param  string $enclosure What to wrap spaced strings in
     * @return string
     */
    protected function strPutCsv($input, $delimiter = ',', $enclosure = '"')
    {
        if (!is_array($input[0])) {
            $input = [$input];
        }

        // Open a memory "file" for read/write...
        $fp = fopen('php://temp', 'r+');
        // ... write the $input array to the "file" using fputcsv()...
        foreach ($input as $inp) {
            fputcsv($fp, $inp, $delimiter, $enclosure);
        }
        // ... rewind the "file" so we can read what we just wrote...
        rewind($fp);
        // ... read the entire line into a variable...
        $data = fread($fp, 1048576);
        // ... close the "file"...
        fclose($fp);
        // ... and return the $data to the caller, with the trailing newline from fgets() removed.

        return $data;
    }

    /**
     *
     * @param  array $printArray        Print Array
     * @param  array $arrayOfProperties An Array of Properties to look for in the Print Array
     * @return array
     */
    public function getArrayProperties($printArray, $arrayOfProperties = [])
    {
        $returnProps = [];

        foreach ($arrayOfProperties as $aop) {
            if (is_array($aop) && isset($printArray[$aop['field']])) {
                $func = $aop['method'];
                $value = $this->$func($printArray[$aop['field']]);
            } else {
                $value = $printArray[$aop] ?? '';
            }
            if (is_array($value)) {
                $returnProps = array_merge($returnProps, $value);
                continue;
            }
            $returnProps[] = $value;
        }

        return $returnProps;
    }

    /**
     * setPrintCopies
     *
     * @param  int  $copies number of copies
     * @return void
     */
    public function setPrintCopies($copies)
    {
        $this->glabelPrintCopies = $copies;
    }

    public function getPrintCopies()
    {
        return $this->glabelPrintCopies;
    }

    /**
     * takes the first comma in an address and splits it into two arrays
     *
     * @param  string $value A Value such as 3/5 Euston WeHave, A problem
     * @return array  the string split into two values
     */
    public function splitValueIntoTwoParts($value): array
    {
        return array_map(
            'trim',
            array_pad(
                explode(
                    ',',
                    $value,
                    2
                ),
                2,
                ''
            )
        );
    }

    /**
     * @param  string $line Line with a potential comma to add a newline
     * @return string
     */
    public function insertNewLineAtComma($line): string
    {
        return preg_replace('/\s*,\s*/', '\n', $line);
    }

    /**
     * send gLabels PDF to designated LPR printer
     *
     * @param  string $printer Print queue name
     * @return array  Array with stdout stderr cmd and return_value
     */
    public function sendPdfToLpr($printer): array
    {
        $jobId = $this->getJobId();

        $cmdArgs = [
            'lpr',
            '-P',
            $printer,
            '-#',
            $this->glabelPrintCopies,
            '-J',
            $jobId,
            '-T',
            $jobId,
        ];

        $returnValue = $this->runProcess(
            $cmdArgs,
            $this->printContent
        );

        // set back to 0 for next run
        $this->setPrintCopies(0);

        return $returnValue;
    }

    /**
     * Send job to gLabels
     *
     * Sends the completed template to the printer held in the $print_settings array
     *
     * @param  \App\Lib\PrintLabels\Glabel\GlabelsProject $template       full path to glabels template
     * @param  array                                      $printerDetails Printer Information
     * @return array                                      Array holding the results of the lpr command
     */
    public function glabelsBatchPrint(GlabelsProject $template, $printerDetails): array
    {
        $this->setGlabelsTemplate($template);

        $this->setPdfOutFile(TMP);

        $this->createTempFile($this->printContent);

        $cmdArgs = [
            '/usr/bin/xvfb-run',
            '--',
            '/usr/local/glabels-qt/usr/bin/glabels-batch-qt',
            '-o',
            $this->getPdfOutFile(),
            $this->getGlabelsTemplate(),
        ];

        /** if ($this->glabelsMergeCSV) {

         * add stdin ("-i -") to glabels command line when piping  CSV data into glabels:
         * glabels-3-batch -i - -o
         *      /var/www/wms/app/tmp/20190701182321-customPrint.pdf
         *      /var/www/wms/app/webroot/files/templates/100x50custom.glabels
         *
         * array_splice($cmdArgs, 1, 0, ['-i', '-']);
         *}
         */

        /**
         * If it's got variable pages such as sequence numbers: 1 of 13, 2 of 13 etc
         * then set the print copies to 1 if it doesn't have variable pages then
         * use the copies set in the child class
         */
        if ($this->variablePages) {
            $this->setPrintCopies(1);
        }

        $results = $this->runProcess(
            $cmdArgs,
            $this->printContent
        );

        //cat merge.csv | glabels-3-batch -o /dev/stdout -i - 100x50sample.glabels | \
        // sed -n '/%PDF-1.5/,/%%EOF/p' | lpr -PPDF -J jobname

        if ($results['return_value'] !== 0) {
            return $results;
        }
        /*
                $pdfPattern = '/(%PDF-1.5.*%%EOF)/s';

                $this->log($results['stdout']);

                preg_match($pdfPattern, $results['stdout'], $matches);
         */
        /**
         * This grabs the PDF file out of the PDF
         */

        $this->setPrintContent(file_get_contents($this->getPdfOutFile()));

        unlink($this->getPdfOutFile());

        return $this->sendPdfToLpr($printerDetails);
    }

    /**
     * run process
     * @param  string $cmd          Command line to run
     * @param  array  $printContent Not sure what this is
     * @return array  array of stdin, out,err and exit code, cmd
     */
    public function runProcess($cmd, $printContent): array
    {
        // code...
        $descriptorspec = [
            0 => ['pipe', 'r'], // stdin
            1 => ['pipe', 'w'], // stdout
            2 => ['pipe', 'w'], // stderr
        ];

        $pipes = [];

        $process = proc_open(
            $cmd,
            $descriptorspec,
            $pipes,
            $this->getCwd(), //cwd orig TMP
            null
        );

        // writing straight to stdin works
        fwrite($pipes[0], $printContent);
        fclose($pipes[0]);

        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        $return_value = proc_close($process);

        /* return an array with all the necessary information */
        return compact('cmd', 'stdout', 'stderr', 'return_value');
    }

    /**
     * getPrintSettings function
     * @param  string $printer           Printer name
     * @param  string $actionOrReference Temporary file name
     * @return array
     */
    public function getPrintSettings($printer, $actionOrReference = ''): array
    {
        return [
            'name' => $printer['queue_name'],
            'job' => $this->getJobId(),
            'options' => $printer['options'],
            'temp_file' => TMP . $actionOrReference . '_print.txt',
        ];
    }

    /**
     * createTempFile
     * create a temporary file in TMP with the contents sent to the printer
     * @param  string $print_content  Print content
     * @param  array  $print_settings as an array
     * @return void
     */
    public function createTempFile($print_content, $print_settings = [])
    {
        if (isset($print_settings['temp_file'])) {
            $tempFile = $print_settings['temp_file'];
        } else {
            $tempFile = TMP . 'PrintTempFile.txt';
        }

        $print_file = new File($tempFile, true, 0644);

        $print_file->write($print_content);

        $print_file->close();
    }

    /**
     * Send job to printer
     *
     * Sends the completed template to the printer held in the $print_settings array
     *
     * @param  string $print_content  template with replaced tokens
     * @param  array  $print_settings Printer name, options, temp file, job name
     * @return array  Array holding the results of the lpr command
     */
    public function sendPrint($print_content, $print_settings = [])
    {
        $this->createTempFile($print_content, $print_settings);

        $cmd = [
            '/usr/bin/lpr',
            '-P', $print_settings['name'],
            $print_settings['options'],
            '-J',
            $print_settings['job'],
        ];

        /* return an array with all the necessary information */
        return $this->runProcess(implode(' ', $cmd), $print_content);
    }
}