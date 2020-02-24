<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "module/report/class-report.php";
include_once "module/module_profile/class.profile.php";
include_once "includes/class.permission.php";

$per_cardno ="3639900042203";
$kpiResult = array("success" => "",
                    "result" => "",
                    "msg" => "");
$cpcResult = array("success" => "",
                    "result" => "",
                    "msg" => "");
$cpcTypeKey = array(1,2,3);

$report = new report;

$years = __year__;
$tablePersonal = "per_personal_2019";
$tableCPCscore = "cpc_score_2019";
(!empty($per_cardno)? $cpcResult =  $report->tableCPC($per_cardno,$years,$cpcTypeKey,$tablePersonal,$tableCPCscore) : $cpcResult);

$r = $report->reportCPC1($cpcResult);


echo "<pre>";
print_r($r);
echo "</pre>";
