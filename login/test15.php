<?php
session_start();
include_once "config.php";
include_once "includes/dbconn.php";
include_once "includes/ociConn.php";
include_once "module/report/class-report.php";


$report = new report;

$r = $report->throughTrial("1500900016462",$dateEvaluation[1]);

echo $r['success']." success <br>";
echo $r['result']."<br>";
echo (isset($r['msg'])?$r['msg']:"");