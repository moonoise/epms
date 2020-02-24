<?php 
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once '../../module/cpc/class-cpc.php';
include_once '../../module/kpi/class-kpi.php';
include_once "../../module/report/class-report.php";
include_once "class-evaluation.php";


$kpi = new kpi;
$cpc = new cpc;
$evaluationClass = new evaluation;
$report = new report;

$kpiResult = array();
$cpcResult = array();

$resultSum = array();

$years = __year__;
// 3930100498198
$cpcTypeKey = array(1,2,3);


$cpcStatus3 = $cpc->cpcStatus3($_POST['per_cardno'],__year__);
$kpiStatus3 = $kpi->kpiStatus3($_POST['per_cardno'],__year__);

if ($cpcStatus3['total_choise'] > 0 && $kpiStatus3['total_choise'] > 0) {
    if ( ($cpcStatus3['total_choise'] == $cpcStatus3['choiseFinish'] ) && $kpiStatus3['total_choise'] == $kpiStatus3['choiseFinish']  ) {
           
        $tableYear = $evaluationClass->getTableYear(__year__);

        $kpiResult = $report->tableKPI($_POST['per_cardno'],__year__,$tableYear['data'][0]['kpi_score']);
        $kpi = $report->reportKPI1($kpiResult);

        $cpcResult =  $report->tableCPC($_POST['per_cardno'],__year__,$cpcTypeKey,$tableYear['data'][0]['per_personal'],$tableYear['data'][0]['cpc_score']);
        $cpc = $report->reportCPC1($cpcResult);

        if ($cpc['through_trial'] == 1 ) {
            $cpc_ratio = 30 ;
            $kpi_ratio = 70;
        }else if ($cpc['through_trial'] == 2) {
            $cpc_ratio = 50 ;
            $kpi_ratio = 50;
        }else {
            $cpc_ratio = 30 ;
            $kpi_ratio = 70;
        }
        $resultSum['cpc_ratio'] = $cpc_ratio;
        $resultSum['kpi_ratio'] = $kpi_ratio;
       
        $resultSum['cpcSum2_user'] = $cpc['cpcSum2_user'];
        $resultSum['kpiSum2_user'] = $kpi['kpiSum2_user'];

        $resultSum['scoreUser'] =  $evaluationClass->sum_cpc_kpi($cpc['cpcSum2_user'],$kpi['kpiSum2_user'],$cpc_ratio,$kpi_ratio);


        if ( ($cpcStatus3['choiseFinish'] == $cpcStatus3['choiseAccepted']) &&  ($kpiStatus3['choiseFinish'] == $kpiStatus3['choiseAccepted'])) {
            $resultSum['cpcSum2_head'] = $cpc['cpcSum2_'];
            $resultSum['kpiSum2_head'] = $kpi['kpiSum2_'];

            if ($cpc['cpcSum2_'] != null && $kpi['kpiSum2_'] != null) {
                $resultSum['scoreHead'] =  $evaluationClass->sum_cpc_kpi($cpc['cpcSum2_'],$kpi['kpiSum2_'],$cpc_ratio,$kpi_ratio);
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




