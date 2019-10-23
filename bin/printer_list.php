<?php
/**
 * Detect local printer
 *
 */

function printer_list()
{
    ob_start();
    passthru("lpstat -a");
    $lpstatOutput = ob_get_contents();
    ob_end_clean(); //Use this instead of ob_flush()

    $printerLines = array_filter(explode("\n", $lpstatOutput));
    $printerQueues = [];
    foreach ($printerLines as $printer) {
        $printer = explode(" ", $printer)[0];
        $printerQueues[] = $printer;
    }
    return $printerQueues;
}

var_dump(printer_list());

var_dump(
    array_combine(
        array_values(
            printer_list()
        ),
        printer_list()
    )
);
