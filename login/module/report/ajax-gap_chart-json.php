<?php
session_start();
include_once '../../config.php';
include_once '../../includes/dbconn.php';
include_once "class-report.php";
include_once "../myClass.php";

$myClass = new myClass;
$currentYear = $myClass->callYear();


$cpcResult = array("success" => "",
                    "result" => "",
                    "msg" => "");
$cpcTypeKey = array(1,2,3,4,5,6);

$report = new report;

(!empty($_POST['per_cardno'])? $cpcResult =  $report->tableCPC($_POST['per_cardno'],$_POST['years'],$cpcTypeKey,$currentYear['data']['per_personal'],$currentYear['data']['cpc_score']) : $cpcResult);
$r = $report->cal_gap_chart($cpcResult);

echo json_encode($r);
