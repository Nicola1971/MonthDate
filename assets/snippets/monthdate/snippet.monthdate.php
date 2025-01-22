<?php
if(!defined('MODX_BASE_PATH')){die('What are you doing? Get out of here!');}
/**
 * MonthDate Snippet - Formats dates with localized month names
 * Works with both system dates and template variables
 * $date - date to use (can be TV or system date)
 * $date2 - backup date (can be TV or system date)
 * $short - insert short month name
 * $outFormat - date output template, a string to replace %d%, %m%, %y%
 * $invalidDate - custom message for invalid dates
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

if (!function_exists('processDateInput')) {
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
        
        // Check for date format with slashes
        if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $dateInput, $matches)) {
            // Determine if it's DD/MM/YYYY or MM/DD/YYYY based on the values
            $part1 = (int)$matches[1];
            $part2 = (int)$matches[2];
            
            if ($part1 > 12 && $part2 <= 12) {
                // Must be DD/MM/YYYY
                $day = $part1;
                $month = $part2;
            } elseif ($part2 > 12 && $part1 <= 12) {
                // Must be MM/DD/YYYY
                $month = $part1;
                $day = $part2;
            } else {
                // Ambiguous case - default to DD/MM/YYYY
                $day = $part1;
                $month = $part2;
            }
            $year = $matches[3];
            
            // Validate date components
            if (checkdate($month, $day, $year)) {
                return mktime(0, 0, 0, $month, $day, $year);
            }
        }
        
        // Try standard strtotime as fallback
        $timestamp = strtotime($dateInput);
        return $timestamp !== false ? $timestamp : false;
    }
}

// Process primary and backup dates
$primaryDate = processDateInput($date);
$backupDate = isset($date2) ? processDateInput($date2) : false;

// Determine which timestamp to use
$timestamp = $primaryDate !== false ? $primaryDate : $backupDate;

try {
    // If no valid date was found, return custom message or empty string
    if ($timestamp === false) {
        return isset($invalidDate) ? $invalidDate : '';
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
    return isset($invalidDate) ? $invalidDate : '';
}
?>