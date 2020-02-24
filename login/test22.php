<?php
include_once "config.php";
include_once "includes/dbconn.php";
include_once "module/report/class-report.php";

$report = new report;

// $part = explode("-",2561-2);
$result = $report->throughTrial(3520400161036,$dateEvaluation[2]);


echo "<pre>";
print_r($result);
echo "</pre>";


// 5120100048111
// 3520400161036