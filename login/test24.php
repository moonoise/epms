<?php 
session_start();
include_once 'config.php';
include_once 'includes/dbconn.php';
include_once "module/report/class-report.php";
include_once "module/module_profile/class.profile.php";
include_once "includes/class.permission.php";

$per_cardno ="5120100048111";
$kpiResult = array("success" => "",
                    "result" => "",
                    "msg" => "");
$cpcResult = array("success" => "",
                    "result" => "",
                    "msg" => "");


$report = new report;

$years = __year__;
(!empty($per_cardno)? $kpiResult = $report->tableKPI($per_cardno,$years,$tbl_kpi_score) : $kpiResult);

$r = $report->reportKPI1($kpiResult);


echo "<pre>";
print_r($r);
echo "</pre>";
