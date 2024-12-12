<?php
if(!defined('MODX_BASE_PATH')){die('What are you doing? Get out of here!');}

/**
 * MonthsDate Snippet - Formats dates with localized month names
 * @param string $date - date to use
 * @param string $date2 - backup date
 * @param bool $short - insert short month name
 * @param string $outFormat - date output template, a string to replace %d%, %m%, %y%
 */

global $modx;
$lang = isset($lang) ? $lang : 'en';
$snip_path = $modx->config['base_path'] . "assets/snippets/";
$_MLang = array();
include($snip_path.'monthsdate/lang/' . $lang . '.php');

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

// Determine which timestamp to use
$timestamp = isset($date2) && $date2 > 0 ? $date2 : $date;

try {
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