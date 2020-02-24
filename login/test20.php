<?php
include_once "config.php";
include_once "includes/dbconn.php";
include_once "module/report/class-report.php";

$report = new report;


$result = $report->getTotal(3,array(3,4,5,5,5));

echo "<pre>";
print_r($result);
echo "</pre>";