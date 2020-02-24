<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once 'module/report/class-report.php';
// include_once "../report/class-report.php";

$per_cardno ="1601100177712";

$person =  new report;
$r = $person->personalThroughTrial($per_cardno,'per_personal_2019');

echo "<pre>";
print_r($r);
echo "</pre>";
