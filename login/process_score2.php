<?php

include_once "config.php";
include_once "includes/dbconn.php";
include_once "module/report/class-report.php";
include_once "module/myClass.php";

$report = new report;
$myClass = new myClass;
$db = new DbConn;

$currentYear = $myClass->callYear();
$year = $currentYear['data']['table_year'];
$cpcScoreTable = $currentYear['data']['cpc_score'];
$kpiScoreTable = $currentYear['data']['kpi_score'];
$personalTable = $currentYear['data']['per_personal'];
$kpiScoreResultTable = $currentYear['data']['kpi_score_result'];
$cpcScoreResultTable = $currentYear['data']['cpc_score_result'];

$cpcTypeKey = array(1,2,3,4,5,6);
// $per_cardno = '1729900270641';


   $sqlPersonal = "select per_cardno from $personalTable ";
   $stm = $db->conn->prepare($sqlPersonal);
   $stm->execute();
   $personalResult = $stm->fetchAll(PDO::FETCH_ASSOC);


   foreach ($personalResult as $key => $value) {
       // $per_cardno = $_POST['per_cardno'];
        $per_cardno = $value['per_cardno'];
        
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
           
        }else {
            $report->cpcUpdateScoreResult($cpcScoreResultTable, $per_cardno, NULL, NULL,  NULL ,  $year ,  NULL);

        }


        $kpiDone = $report->KPIscoreDone($per_cardno,$kpiScoreTable,$year);
        if ($kpiDone['success'] == true && $kpiDone['result'] === 0 && $kpiDone['checkaccept'] === 0 ) {

            (!empty($per_cardno)? $kpiResult = $report->tableKPI($per_cardno,$year,$personalTable,$kpiScoreTable) : $kpiResult);
            $kpi = $report->reportKPI1($kpiResult);
            $kpiResultUpdate =  $report->kpiResultUpdate($kpi,$currentYear['data']);

            
            $log_['kpiResultUpdate'] = $kpiResultUpdate;
        }else {
            $report->KPIupdateScoreResult( $kpiScoreResultTable,  $per_cardno,  NULL,  NULL,  $year,  NULL);
            
        }

        

        

        printf("%s , per_cardno -> %s  , %s , %s \n",$key ,$per_cardno ,  $log_['updateResutl']['success'],$log_['kpiResultUpdate']['success']);
        // echo json_encode($updateResult);
        
        $log_['updateResutl'] = "";
        $log_['gapUpdate'] = "";
        $log_['kpiResultUpdate'] = "";
        
   }

