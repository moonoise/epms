<?php
session_start();
include_once '../../config.php';
include_once '../../includes/dbconn.php';
include_once "class-report.php";


$cpcResult = array("success" => "",
                    "result" => "",
                    "msg" => "");
$cpcTypeKey = array(1,2,3,4,5,6);
$success =  array();
$success['text'] = "";
$report = new report;

(!empty($_POST['per_cardno'])? $cpcResult =  $report->tableCPC($_POST['per_cardno'],$_POST['years'],$cpcTypeKey,$tbl_per_personal,$tbl_cpc_score) : $cpcResult);
$r = $report->cal_gap_chart($cpcResult);

foreach ($r as $key => $value) {
    if ($value['result_minus'] < 0) {
        $success['text'] .= "<tr>";
        $success['text'] .= "<td>ปิดจุดอ่อน</td>";
        $success['text'] .= "<td>[".$value['question_code']."] ".$value['question_title']."</td>";
        $success['text'] .= "</tr>";
    }
   
}

