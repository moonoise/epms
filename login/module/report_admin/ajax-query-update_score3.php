<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../report/class-report.php";
include_once "../myClass.php";

$updateResult = array("success" => NULL,
                        "result" => NULL,
                        "msg" => NULL,
                        "log" => NULL );

$report = new report;
$myClass = new myClass;

$currentYear = $myClass->callYear();
$year = $currentYear['data']['table_year'];
$cpcScoreTable = $currentYear['data']['cpc_score'];
$kpiScoreTable = $currentYear['data']['kpi_score'];
$personalTable = $currentYear['data']['per_personal'];
$kpiScoreResultTable = $currentYear['data']['kpi_score_result'];
$cpcScoreResultTable = $currentYear['data']['cpc_score_result'];

$cpcTypeKey = array(1,2,3,4,5,6);
$msg_result = $_POST['per_cardno']."";
$per_cardno = $_POST['per_cardno'];
// $per_cardno = '1729900270641';
$msg_error = "";
$log = array();
$log_ = array();
$doneScore = $report->CPCscoreDone($per_cardno,$cpcScoreTable,$year);
if ($doneScore['result'] === 0) {

    (!empty($per_cardno)? $cpcResult =  $report->tableCPC($per_cardno,$year,$cpcTypeKey,$personalTable,$cpcScoreTable) : $cpcResult);
    $cpc = $report->reportCPC1($cpcResult);
    $updateResutl = $report->cpcResultUpdate($cpc,$currentYear['data']);

    $r = $report->cal_gap_chart($cpcResult);

    $gapUpdate = array();

    foreach ($r as $keyGapUpdate => $valueGapUpdate) {

        $gapUpdate[] = $report->gapUpdateByid($valueGapUpdate['pointEqual_OverGap'],$valueGapUpdate['gap_status'],$valueGapUpdate['cpc_score_id'],$cpcScoreTable);

    }
    $log_['updateResutl'] =  $updateResutl;
    $log_['gapUpdate'] = $gapUpdate;
    $msg_result .= " <span class='text text-success'> สมรรถนะ ประเมินเสร็จแล้ว </span>";
}else {
    $report->cpcUpdateScoreResult($cpcScoreResultTable, $per_cardno, NULL, NULL,  NULL ,  $year ,  NULL);

    $msg_result .= " <span class='text text-warning'> สมรรถนะ ยังประเมินไม่เสร็จ</span>" ;
}


$kpiDone = $report->KPIscoreDone($per_cardno,$kpiScoreTable,$year);
if ($kpiDone['success'] == true && $kpiDone['result'] === 0 && $kpiDone['checkaccept'] === 0 ) {

    (!empty($per_cardno)? $kpiResult = $report->tableKPI($per_cardno,$year,$personalTable,$kpiScoreTable) : $kpiResult);
    $kpi = $report->reportKPI1($kpiResult);
    $kpiUpdateResutl =  $report->kpiResultUpdate($kpi,$currentYear['data']);

    $msg_result .= "<span class='text text-info'> ตัวชี้วัด ยังประเมินเสร็จแล้ว</span>";
    $log_['kpiResultUpdate'] = $kpiResultUpdate;
}else {
    $report->KPIupdateScoreResult( $kpiScoreResultTable,  $per_cardno,  NULL,  NULL,  $year,  NULL);
    $msg_result .= " <span class='text text-warning'> ตัวชี้วัด ยังประเมินไม่เสร็จ</span>" ;
}

$log[] = $log_;

$updateResult = array("success" => true,
                        "result" => $msg_result,
                        "msg" => null,
                        "log" => $log);

echo json_encode($updateResult);