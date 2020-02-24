<?php
session_start();
include_once "../config.php";
include_once "../includes/dbconn.php";
include_once "report/class-report.php";
include_once "myClass.php";

$report = new report;
$myClass = new myClass;

$currentYear = $myClass->callYear();
$cpcTypeKey = array(1,2,3,4,5,6);



$per_cardno = '1559900202540';


(!empty($per_cardno)? $kpiResult = $report->tableKPI($per_cardno,$currentYear['data']['table_year'],$currentYear['data']['kpi_score']) : $kpiResult);

$kpi = $report->reportKPI1($kpiResult);
$kpiUpdateResutl =  $report->kpiResultUpdate($kpi,$currentYear['data']);

(!empty($per_cardno)? $cpcResult =  $report->tableCPC($per_cardno,$currentYear['data']['table_year'],$cpcTypeKey,$currentYear['data']['per_personal'],$currentYear['data']['cpc_score']) : $cpcResult);
$cpc = $report->reportCPC1($cpcResult);
$updateResutl = $report->cpcResultUpdate($cpc,$currentYear['data']);

$r = $report->cal_gap_chart($cpcResult);
$gap = $report->cal_gap($r);
$idp = $report->cal_idp($per_cardno,$years);
$gapUpdate = array();

foreach ($r as $keyGapUpdate => $valueGapUpdate) {

    $gapUpdate[] = $report->gapUpdateByid($valueGapUpdate['pointEqual_OverGap'],$valueGapUpdate['gap_status'],$valueGapUpdate['cpc_score_id'],$currentYear['data']['cpc_score']);

}

echo "<pre>";
print_r($kpiUpdateResutl);
echo "</pre>";

echo "<pre>";
print_r($updateResutl);
echo "</pre>";

echo "<pre>";
print_r($gapUpdate);
echo "</pre>";
