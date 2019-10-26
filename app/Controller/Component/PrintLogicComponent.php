<?php

App::uses('Component', 'Controller');
App::uses('File', 'Utility');
App::uses('glabelsException', 'Lib');

/**
 * PrintLogic component
 * Manages printing to CAB printer and formatting check digit
 */
class PrintLogicComponent extends Component
{

    /**
     * @var int
     */
    private $glabelPrintCopies = 0;
    /**
     * @var bool
     */
    private $glabelsMergeCSV = false;

    /**
     * @var string
     */
    private $glabelsTemplate = '';
    /**
     * @var string
     */
    private $outFile = 'output.pdf';
    /**
     * @var string
     */
    private $printContent = '';
    /**
     * @var array
     */
    private $printContentArray = [];
    /**
     * @var mixed
     */
    private $cwd = null;
    /**
     * @var string
     */
    private $jobId = '';

    /**
     * @var array
     */
    private $_actionToFunctionMap = [
        'glabel_sample_labels' => 'formatGLabelSample',
        'keep_refrigerated' => 'formatCustomLabel',
        'custom_print' => 'formatCustomLabel',
        'shipping_labels' => 'formatShippingLabelPrintLine',
        'crossdock_labels' => 'formatCrossdockLabelPrintLine',
        'shipping_labels_generic' => 'formatShippingLabelsGeneric',
        'sample_labels' => 'formatSampleLabel'
    ];

    /**
     * @param Controller $controller
     */
    public function initialize(Controller $controller)
    {
        $this->Controller = $controller;
        $this->Model = $this->Controller->{$this->Controller->modelClass};
        $this->modelAlias = $this->Model->alias;
        parent::initialize($controller);
    }

    /**
     * Takes PrintData and sends to a specially formatting functions which creates the CSV for gLabels
     * @param string $action the controller action of the calling page e.g. where they pressed the print button
     * @param array $printData an array of the print data to format
     * @return void
     */
    public function formatPrintLine($action, $printData)
    {
        if (!array_key_exists($action, $this->_actionToFunctionMap)) {
            throw new glabelsException("Function mapping missing in " . __FILE__);
        }

        $this->setPrintContentArray($printData);
        $this->setJobId($action);
        $this->setCwd(TMP);
        $this->setOutFile(TMP);

        $formatFunction = $this->_actionToFunctionMap[$action];

        $this->$formatFunction($printData);
    }

    /**
     * gets the current working directory
     * @return string
     */
    public function getCwd()
    {
        return $this->cwd;
    }
    /**
     * Sets the current working directory for the print process
     * @param string $cwd usually TMP is passed in
     * @return void
     */
    public function setCwd($cwd)
    {
        $this->cwd = $cwd;
    }

    /**
     * @param array $printArray an array
     * @return void
     */
    public function setPrintContentArray($printArray)
    {
        $this->printContentArray = $printArray;
    }

    /**
     * @param string $value Get an array value when passed a key
     * @return mixed
     */
    public function getPrintContentArrayValue($value)
    {
        if (isset($this->printContentArray[$value])) {
            return $this->printContentArray[$value];
        } else {
            throw new glabelsException(
                "value: " . $value . ' does not exist in ' .
                print_r($this->printContentArray, true)
            );
        }
    }
    /**
     * @param string $template Template from config
     */
    public function setGlabelsTemplate($template)
    {
        $this->glabelsTemplate = realpath($template);
    }
    /**
     * Formats a date as YYYYMMDDHHMMSS
     * @return string
     */
    private function formatDate()
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
     * @param string $actionOrReference pass in the controller action e.g. carton_print or a pallet reference e.g. 0023456
     * @param bool $reprint if reprint append 'reprint'
     */
    public function setJobId($actionOrReference = '', $reprint = false)
    {
        $fmtDate = $this->formatDate();

        if ($actionOrReference !== '') {
            $actionOrReference = '-' . $actionOrReference;
        }

        if ($reprint) {
            $actionOrReference .= '-reprint';
        }

        $this->jobId = $fmtDate . $actionOrReference;

        return $this->jobId;
    }
    /**
     * Sets the output file name and path
     * @param string $rootDir The root directory usually TMP/file.pdf
     * @return void
     */
    public function setOutFile($rootDir)
    {
        $this->outFile = $rootDir . $this->getJobId() . '.pdf';
    }
    /**
     * @return mixed
     */
    public function getOutFile()
    {
        return $this->outFile;
    }

    /**
     * @param mixed $content Print Content
     */
    private function setPrintContent($content)
    {
        $this->printContent = $content;
    }

    /**
     * @param array $input Array to convert to CSV
     * @param string $delimiter Typically a comma
     * @param string $enclosure What to wrap spaced strings in
     * @return string
     */
    private function strPutCsv($input, $delimiter = ',', $enclosure = '"')
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
     * @param array $printArray Print Array
     * @param array $arrayOfProperties An Array of Properties to look for in the Print Array
     * @return mixed
     */
    public function getArrayProperties($printArray, $arrayOfProperties = [])
    {
        $returnProps = [];
        foreach ($arrayOfProperties as $aop) {
            if (is_array($aop) && isset($printArray[$aop[1]])) {
                $func = $aop[0];
                $value = $this->$func($printArray[$aop[1]]);
            } else {
                $value = isset($printArray[$aop]) ? $printArray[$aop] : '';
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
     * @param array $printArray
     */
    public function formatSampleLabel($printArray)
    {
        //"Product name","Product Batch","01/09/2018","04/09/2018","Product Comment Here 36 Characters"
        $props = [
            'productName',
            'batch',
            'manufactureDate',
            'bestBefore',
            'comment'
        ];
        $returnedProps = $this->getArrayProperties($printArray, $props);

        $copies = $printArray['copies'];
        $printLines = [];

        $this->glabelsMergeCSV = true;

        for ($i = 1; $i <= $copies; $i++) {
            $printLines[] = $returnedProps;
        }

        $printThis = $this->strPutCsv($printLines);

        $this->setPrintContent($printThis);
    }

    /**
     * @param $printData
     */
    public function setPrintCopies($copies)
    {

        $this->glabelPrintCopies = $copies;
    }
    /**
     * @param $printArray
     */
    public function formatGLabelSample($printArray)
    {
        $this->glabelsMergeCSV = false;
        $this->setPrintCopies($printArray['copies']);
        $this->setPrintContent(null);
    }

    /**
     * @param array $printArray Print Array
     * @return void
     */
    public function formatCustomLabel($printArray)
    {

        $printLines = [];
        $printThis = null;

        $copies = $printArray['copies'];

        if (isset($printArray['csv']) && is_array($printArray['csv'])) {

            // merge is 1 copy

            for ($i = 1; $i <= $copies; $i++) {
                $printLines[] = $printArray['csv'];
            }

            $printThis = $this->strPutCsv($printLines);

            $this->glabelsMergeCSV = true;
            $this->setPrintCopies(1);

        } else {
            $this->glabelsMergeCSV = false;
            $this->setPrintCopies($copies);
        }

        $this->setPrintContent($printThis);
    }
    /**
     * @param $printArray
     */
    public function formatShippingLabelsGeneric($printArray)
    {
        $arrayOfProps = [
            'companyName',
            'productName',
            'productDescription',
            'genericLine1',
            'genericLine2',
            'genericLine3',
            'genericLine4',
            'copies'
        ];

        $retArrayOfProps = $this->getArrayProperties($printArray, $arrayOfProps);

        $copies = $printArray['copies'];

        $this->glabelsMergeCSV = true;

        $printLines = [];

        for ($i = 1; $i <= $copies; $i++) {
            $loopArray = $retArrayOfProps;
            array_splice($loopArray, 7, 0, $i);
            $printLines[] = $loopArray;
        }
        $printThis = $this->strPutCsv($printLines);

        $this->setPrintContent($printThis);
    }

    /**
     * takes the first comma in an address and splits it into two arrays
     * @param string $value A Value such as 3/5 Euston WeHave, A problem
     * @return array the string split into two values
     */
    public function splitValueIntoTwoParts($value)
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
     * Crossdock Labels
     * @param array $printArray cakephp array from form with model
     * @return void
     */
    public function formatCrossdockLabelPrintLine($printArray)
    {
        $csvHeadings = [
            'PURCHASE_ORDER', 'BOOKED_DATE', 'SENDTO_NAME', 'SENDTO_ADDR1',
            'SENDTO_ADDR2', 'TOTAL_PLS', 'PL_NUM', 'SENDING_CO'
        ];
        $props = [
            'purchase_order', 'booked_date', 'sending_co',
            ['splitValueIntoTwoParts', 'address'], 'sequence-end', 'sending_co'
        ];

        $printArrayValues = $this->getArrayProperties($printArray, $props);

        $sequenceStart = $printArray['sequence-start'];
        $sequenceEnd = $printArray['sequence-end'];
        $copies = $printArray['copies'];
        $this->glabelsMergeCSV = true;

        $printLines = [];
        $printLines[] = $csvHeadings;

        for ($i = $sequenceStart; $i <= $sequenceEnd; $i++) {
            for ($j = 1; $j <= $copies; $j++) {
                $loopArray = $printArrayValues;
                array_splice($loopArray, 6, 0, $i);
                $printLines[] = $loopArray;
            }
        };

        $printThis = $this->strPutCsv($printLines);

        $this->setPrintContent($printThis);
    }

    /**
     * @param $line
     */
    public function insertNewLineAtComma($line)
    {
        return preg_replace('/\s*,\s*/', '\n', $line);
    }
    /**
     * @param $printArray
     */
    public function formatShippingLabelPrintLine($printArray)
    {
        $sequenceStart = $printArray['sequence-start'];
        $sequenceEnd = $printArray['sequence-end'];
        $copies = $printArray['copies'];

        $this->glabelsMergeCSV = true;

        $reference = $printArray['reference'];
        $state = $printArray['state'];

        $lookUpProps = [
            "BLANK",
            ['insertNewLineAtComma', 'address'],
            'reference',
            'state',
            'sequence-end'
        ];

        $props = $this->getArrayProperties($printArray, $lookUpProps);

        $printLines = [];

        for ($i = $sequenceStart; $i <= $sequenceEnd; $i++) {
            for ($j = 1; $j <= $copies; $j++) {
                $loopArray = $props;
                array_splice($loopArray, 4, 0, $i);
                $printLines[] = $loopArray;
            }
        }

        $printThis = $this->strPutCsv($printLines);

        $this->setPrintContent($printThis);
    }
    /**
     * send gLabels PDF to designated LPR printer
     * @param string $printer Print queue name
     * @return array Array with stdout stderr cmd and return_value
     */
    public function sendPdfToLpr($printer)
    {
        /* the print file is no longer used but may be handy if things
         * don't work as they should so leaving it here
         */
        $print_file = new File($this->outFile);

        $jobId = $this->getJobId();

        $copies = $this->glabelPrintCopies;

        $cmdArgs = [
            'lpr',
            '-P',
            $printer,
            '-#',
            $copies,
            $this->outFile,
            '-J',
            $jobId,
            '-T',
            $jobId
        ];

        $returnValue = $this->runProcess(
            implode(' ', $cmdArgs),
            $this->printContent
        );

        if ($returnValue['return_value'] === 0) {
            $print_file->delete();
        } else {
            $print_file->close();
        }

        // set back to 0 for next run
        $this->setPrintCopies(0);
        return $returnValue;
    }

    /**
     * Send job to gLabels
     *
     * Sends the completed template to the printer held in the $print_settings array
     *
     * @param bool $merge Whether print uses a CSV merge input data or just a template only
     * @return array Array holding the results of the lpr command
     */
    public function glabelsBatchPrint()
    {
        $cmdArgs = [
            'glabels-3-batch',
            '-o',
            $this->outFile,
            $this->glabelsTemplate
        ];

        if ($this->glabelsMergeCSV) {
            $this->setPrintCopies(1);
            /**
             * add stdin to glabels command line when piping  CSV data into glabels
             * glabels-3-batch -i - -o /var/www/wms/app/tmp/20190701182321-custom_print.pdf /var/www/wms/app/webroot/files/templates/100x50custom.glabels
             */
            array_splice($cmdArgs, 1, 0, ['-i', '-']);
        }

        return $this->runProcess(
            implode(' ', $cmdArgs),
            $this->printContent
        );
    }

    /**
     * run process
     * @param string $cmd Command line to run
     * @param array $printContent Not sure what this is
     * @return array array of stdin, out,err and exit code, cmd
     */
    public function runProcess($cmd, $printContent)
    {
        # code...
        $descriptorspec = [
            0 => ["pipe", "r"], // stdin
            1 => ["pipe", "w"], // stdout
            2 => ["pipe", "w"] // stderr
        ];

        $pipes = [];

        $process = proc_open(
            $cmd,
            $descriptorspec,
            $pipes,
            $this->getCwd(), //cwd orig TMP
            null// env null = current
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
        $returnValue = [
            'cmd' => $cmd,
            'stdout' => $stdout,
            'stderr' => $stderr,
            'return_value' => $return_value
        ];

        return $returnValue;
    }

    /**
     * getPrintSettings function
     * @param string $printer_name Printer name
     * @param string $print_job Print job name
     * @param array $options Array of options
     * @param string $tmp_file Temporary file name
     * @return array
     */
    public function getPrintSettings($printer_name, $print_job, $options, $tmp_file)
    {
        return [
            'name' => $printer_name,
            'job' => $print_job,
            'options' => $options,
            'temp_file' => TMP . $tmp_file . '_print.txt'
        ];
    }

    /**
     * Takes reference number and formats it as date - reference and if reprint is true adds -reprint
     * e.g.20170126232221-B0123456 or 20170126232221-00123456-reprint
     *
     * @param string $reference The Pallet Reference number
     * @param bool $reprint Whether this is a reprint or not default = false
     * @return string
     */
    public function getPrintJobName($referenceOrAction, $reprint = false)
    {
        $this->setJobId($referenceOrAction, $reprint);

        return $this->getJobId();
    }
    /**
     * createTempFile
     * create a temporary file in TMP with the contents sent to the printer
     *
     */
    public function createTempFile($print_content, $print_settings = [])
    {

        if (isset($print_settings['temp_file'])) {
            $tempFile = $print_settings['temp_file'];
        } else {
            $tempFile = TMP . 'PrintLogicTempFile.txt';
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
     * @param string $print_content template with replaced tokens
     * @param array $print_settings Printer name, options, temp file, job name
     * @return array Array holding the results of the lpr command
     */
    public function sendPrint($print_content, $print_settings = [])
    {
        $this->createTempFile($print_content, $print_settings);

        $cmd = [
            '/usr/bin/lpr', '-P',
            $print_settings['name'],
            $print_settings['options'], '-J',
            $print_settings['job']
        ];

        /* return an array with all the necessary information */
        return $this->runProcess(implode(' ', $cmd), $print_content);
    }
}
