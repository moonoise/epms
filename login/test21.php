<?php
include_once "config.php";
include_once "includes/dbconn.php";
include_once "module/report/class-report.php";

$report = new report;

$type = array(1,2,3);
$result = $report->getPoint(array(3,5,2,5,2));

echo "<pre>";
print_r($result);
echo "</pre>";