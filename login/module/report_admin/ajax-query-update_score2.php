<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../report/class-report.php";
include_once "..//myClass.php";
$classReport = new report;
$myClass = new myClass;

$updateResult = array("success" => null,
                    "result" => null,
                    "msg" => null );

$currentYear = $myClass->callYear();
$cpcTypeKey = array(1,2,3);
$cpcTypeKey2 = array(1,2,3,4,5,6);

$msg_result = $_POST['per_cardno']."";
$msg_error = "";
// CPC 

// $test = $classReport->CPCscoreDone("1129800068519","cpc_score_2019","2019-1");
$doneScore = $classReport->CPCscoreDone($_POST['per_cardno'],$_POST['cpc_score'],$_POST['table_year']);
if ($doneScore['result'] === 0) {   //เท่ากับ 0 ให้ save คะแนน

    $cpcResult =  $classReport->tableCPC($_POST['per_cardno'],$currentYear['data']['table_year'],$cpcTypeKey,$currentYear['data']['per_personal'],$currentYear['data']['cpc_score']);
    $cpc = $classReport->reportCPC1($cpcResult);
    $updateResutl = $report->cpcResultUpdate($cpc,$currentYear['data']);
    
    if ($cpcResult['result'][0]['through_trial'] == 1 ) {
        $AverageCPC = 30; 
    }elseif ($cpcResult['result'][0]['through_trial'] == 2) {
        $AverageCPC = 50; 
    }else {
        $AverageCPC = 30; 
    }

    $checkSave = $classReport->cpcUpdateScoreResult($_POST['cpc_score_result'],$_POST['per_cardno'],$cpc['cpcSum2'],$AverageCPC,$_POST['table_year']); 

    if ($checkSave['success'] == true) {
       
        $msg_result .= " <span class='text text-success'> สมรรถนะ ประเมินเสร็จแล้ว (".$checkSave['result'].") </span>";

    }else {
        
        $msg_error .= $checkSave['msg'];
        
    } 

}elseif ( $doneScore['result'] > 0 || $doneScore['result'] == null ) {  //บันทึกลงในตารางเป็นค่า null แล้ว return  กลับไปว่ายังประเมินไม่เสร็จ

    $checkSave = $classReport->cpcUpdateScoreResult($_POST['cpc_score_result'],$_POST['per_cardno'],null,null,$_POST['table_year']);
    if ($checkSave['success'] == true) {
        $msg_result .= " <span class='text text-warning'> สมรรถนะ ยังประเมินไม่เสร็จ</span>" ;
        
    }elseif ($checkSave['success'] == null) {
        $msg_error['msg'] .= $checkSave['msg'];
    }      
}

//KPI
$kpiDone = $classReport->KPIscoreDone($_POST['per_cardno'],$_POST['kpi_score'],$_POST['table_year']);
if ($kpiDone['success'] == true && $kpiDone['result'] === 0 && $kpiDone['checkaccept'] === 0 ) {
    $kpiResult = $classReport->tableKPI($_POST['per_cardno'],$_POST['table_year'],$_POST['kpi_score']) ;
    $kpi = $classReport->reportKPI1($kpiResult);
    $ThroughTrial = $classReport->personalThroughTrial($_POST['per_cardno'],$_POST['per_personal']);

        if ($ThroughTrial['result'] == 1 ) {
            $AverageKPI = 70;
            
        }elseif ($ThroughTrial['result'] == 2) {
            $AverageKPI = 50;
            
        }else {
            $AverageKPI = 70;
        }

        $saveKPI = $classReport->KPIupdateScoreResult($_POST['kpi_score_result'],$_POST['per_cardno'],$kpi['kpiSum2'],$AverageKPI,$_POST['table_year']);
        if ($saveKPI['success'] == true) {
            $msg_result .= "<span class='text text-info'> ตัวชี้วัด ยังประเมินเสร็จแล้ว (".$saveKPI['result'].") </span>";
        }else {
            $msg_error['msg'] .= $saveKPI['msg'];
        }
            
}elseif ($kpiDone['success'] == true && ($kpiDone['result'] > 0 || $kpiDone['result'] == null || $kpiDone['checkaccept'] > 0 || $kpiDone['checkaccept'] == null) ) {

    $saveKPI = $classReport->KPIupdateScoreResult($_POST['kpi_score_result'],$_POST['per_cardno'],null,null,$_POST['table_year']);

    if ($saveKPI['success'] == true) {
        $msg_result .= " <span class='text text-warning'> ตัวชี้วัด ยังประเมินไม่เสร็จ</span>" ;
    }elseif ($saveKPI['success'] == null) {
        $msg_error['msg'] .= $saveKPI['msg'];
    }    
   
}elseif ($kpiDone['success'] == null) {
    $msg_error .= $kpiDone['msg'];
}

if ($msg_error != "") {
    $updateResult = array("success" => null,
                    "result" => $msg_result.$msg_error,
                    "msg" => $msg_error );
}elseif ($msg_error == "") {
    $updateResult = array("success" => true,
                    "result" => $msg_result,
                    "msg" => null);
}

// elseif ($doneScore == null ) {


//     $updateResult = array("success" => null,
//                     "result" => null,
//                     "msg" => "error." );
    
// }


echo json_encode($updateResult);


// echo "<pre>";
// print_r($kpi['kpiSum2']);
// echo "</pre>";

