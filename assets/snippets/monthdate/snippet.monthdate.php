<?php
if(!defined('MODX_BASE_PATH')){die('What are you doing? Get out of here!');}

/**
 * MonthDate Snippet - Formats dates with localized month names
 * Works with both system dates and template variables
 * $date - date to use (can be TV or system date)
 * $date2 - backup date (can be TV or system date)
 * $short - insert short month name
 * $outFormat - date output template, a string to replace %d%, %m%, %y%
 */

global $modx;
$lang = isset($lang) ? $lang : 'en';
$snip_path = $modx->config['base_path'] . "assets/snippets/";
$_MLang = array();
include($snip_path.'monthdate/lang/' . $lang . '.php');

$fullMonth = array(
    '1' => $_MLang['fm1'],
    '2' => $_MLang['fm2'],
    '3' => $_MLang['fm3'],
    '4' => $_MLang['fm4'],
    '5' => $_MLang['fm5'],
    '6' => $_MLang['fm6'],
    '7' => $_MLang['fm7'],
    '8' => $_MLang['fm8'],
    '9' => $_MLang['fm9'],
    '10' => $_MLang['fm10'],
    '11' => $_MLang['fm11'],
    '12' => $_MLang['fm12']
);

$shortMonth = array(
    '1' => $_MLang['sm1'],
    '2' => $_MLang['sm2'],
    '3' => $_MLang['sm3'],
    '4' => $_MLang['sm4'],
    '5' => $_MLang['sm5'],
    '6' => $_MLang['sm6'],
    '7' => $_MLang['sm7'],
    '8' => $_MLang['sm8'],
    '9' => $_MLang['sm9'],
    '10' => $_MLang['sm10'],
    '11' => $_MLang['sm11'],
    '12' => $_MLang['sm12']
);

// Function to process date input (handles both timestamps and formatted dates)
function processDateInput($dateInput) {
    global $modx;
    
    // If it's a TV placeholder, get its value
    if (strpos($dateInput, '[*') !== false) {
        $tvName = trim(str_replace(array('[*', '*]'), '', $dateInput));
        $dateInput = $modx->documentObject[$tvName][1] ?? $modx->documentObject[$tvName] ?? '';
    }
    
    // If empty, return false
    if (empty($dateInput)) {
        return false;
    }
    
    // If it's already a timestamp, return it
    if (is_numeric($dateInput) && strlen($dateInput) === 10) {
        return (int)$dateInput;
    }
    
    // Try to convert the date string to timestamp
    $timestamp = strtotime($dateInput);
    return $timestamp !== false ? $timestamp : false;
}

// Process primary and backup dates
$primaryDate = processDateInput($date);
$backupDate = isset($date2) ? processDateInput($date2) : false;

// Determine which timestamp to use
$timestamp = $primaryDate !== false ? $primaryDate : $backupDate;

try {
    // If no valid date was found, throw exception
    if ($timestamp === false) {
        throw new Exception('No valid date provided');
    }
    
    // Create DateTime object from timestamp
    $dateObj = new DateTime();
    $dateObj->setTimestamp($timestamp);
    
    // Get date components
    $day = $dateObj->format('d');
    $month = (int)$dateObj->format('m');
    $year = $dateObj->format('Y');
    
    // Get localized month name
    $monthName = isset($short) ? $shortMonth[$month] : $fullMonth[$month];
    
    // Format output
    if (isset($outFormat)) {
        $searchArray = array("%d%", "%m%", "%y%");
        $replaceArray = array($day, $monthName, $year);
        $return = str_replace($searchArray, $replaceArray, $outFormat);
    } else {
        $return = $day . '&nbsp;' . $monthName . '&nbsp;' . $year;
    }
    
    return $return;
    
} catch (Exception $e) {
    $modx->logEvent(1, 3, 'Error processing date in MonthsDate snippet: ' . $e->getMessage());
    return '';
}
?>