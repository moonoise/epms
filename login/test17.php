<?php
include_once "config.php";
include_once "includes/dbconn.php";
include_once "module/report/class-report.php";

$report = new report;
$cpcTypeKey = array(3);
$result = $report->cpcCalculate('1189800031101','2556-1',$cpcTypeKey);

echo "<pre>";
print_r($result);
echo "</pre>";


?>