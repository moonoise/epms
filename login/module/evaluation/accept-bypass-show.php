<?php 
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once '../../module/cpc/class-cpc.php';
include_once '../../module/kpi/class-kpi.php';
include_once "../../module/report/class-report.php";
include_once "class-evaluation.php";
include_once "../myClass.php";

$kpi = new kpi;
$cpc = new cpc;
$evaluationClass = new evaluation;
$report = new report;

$myClass = new myClass;
$currentYear = $myClass->callYear();
$cpcScoreTable = $currentYear['data']['cpc_score'];
$kpiScoreTable = $currentYear['data']['kpi_score'];
$year = $currentYear['data']['table_year'];
$personalTable = $currentYear['data']['per_personal'];

$kpiResult = array();
$cpcResult = array();

$resultSum = array();

// 3930100498198
$cpcTypeKey = array(1,2,3);


$cpcStatus3 = $cpc->cpcStatus3($_POST['per_cardno'],$year,$cpcScoreTable );
$kpiStatus3 = $kpi->kpiStatus3($_POST['per_cardno'],$year,$kpiScoreTable);

if ($cpcStatus3['total_choise'] > 0 && $kpiStatus3['total_choise'] > 0) {
    if ( ($cpcStatus3['total_choise'] == $cpcStatus3['choiseFinish'] ) && $kpiStatus3['total_choise'] == $kpiStatus3['choiseFinish']  ) {
           

        $kpiResult = $report->tableKPI($_POST['per_cardno'],$year,$personalTable,$kpiScoreTable);
        $kpi = $report->reportKPI1($kpiResult);

        $cpcResult =  $report->tableCPC($_POST['per_cardno'],$year,$cpcTypeKey,$personalTable,$cpcScoreTable);
        $cpc = $report->reportCPC1($cpcResult);

    
        $resultSum['cpc_ratio'] = $cpc['scoring'];
        $resultSum['kpi_ratio'] = $kpi['scoring'];
       
        $resultSum['cpcSum2_user'] = $cpc['cpcSum2_user'];
        $resultSum['kpiSum2_user'] = $kpi['kpiSum2_user'];

        $resultSum['scoreUser'] =  $report->sum_cpc_kpi($cpc['cpcSum2_user'],$kpi['kpiSum2_user'],$cpc['scoring'],$kpi['scoring']);


        if ( ($cpcStatus3['choiseFinish'] == $cpcStatus3['choiseAccepted']) &&  ($kpiStatus3['choiseFinish'] == $kpiStatus3['choiseAccepted'])) {
            $resultSum['cpcSum2_head'] = $cpc['cpcSum2_'];
            $resultSum['kpiSum2_head'] = $kpi['kpiSum2_'];

            if ($cpc['cpcSum2_'] != null && $kpi['kpiSum2_'] != null) {
                $resultSum['scoreHead'] =  $report->sum_cpc_kpi($cpc['cpcSum2_'],$kpi['kpiSum2_'],$cpc['scoring'],$kpi['scoring']);
            }else {
                $resultSum['scoreHead'] = null;
            }

        }else {
            $resultSum['cpcSum2_head'] = "-";
            $resultSum['kpiSum2_head'] = "-";
            
        }

        // echo json_encode($cpcResult);
        echo json_encode($resultSum);
    }else {
        $resultSum['cpcSum2_user'] = "-";
        $resultSum['kpiSum2_user'] = "-";
        $resultSum['cpcSum2_head'] = "-";
        $resultSum['kpiSum2_head'] = "-";

        $resultSum['cpc_ratio'] = "-";
        $resultSum['kpi_ratio'] = "-";
        $resultSum['scoreUser'] = "-";
        $resultSum['scoreHead'] = "-";
        echo json_encode($resultSum);
        
    }
}




