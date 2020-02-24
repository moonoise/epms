<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once 'module/report/class-report.php';
// include_once "../report/class-report.php";



$person =  new report;
$per_cardno = $_POST['per_cardno'];

$r = $person->KPIscoreDone($per_cardno,'kpi_score_2019','2019-1');

echo "<pre>";
print_r($r);
echo "</pre>";