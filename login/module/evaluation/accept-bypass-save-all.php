<?php 
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once '../../module/cpc/class-cpc.php';
include_once '../../module/kpi/class-kpi.php';
include_once "class-evaluation.php";


$kpi = new kpi;
$cpc = new cpc;
$evaluationClass = new evaluation;

$kpiResult = array("success" => "",
                    "result" => "",
                    "msg" => "");
$cpcResult = array("success" => "",
                    "result" => "",
                    "msg" => "");

$years = __year__;
// 3930100498198

$cpcStatus3 = $cpc->cpcStatus3($_POST['accept_per_cardno'],$_POST['accept_year']);
$kpiStatus3 = $kpi->kpiStatus3($_POST['accept_per_cardno'],$_POST['accept_year']);

if ($cpcStatus3['total_choise'] > 0 && $kpiStatus3['total_choise'] > 0) {
    if ( ($cpcStatus3['total_choise'] == $cpcStatus3['choiseFinish'] ) && $kpiStatus3['total_choise'] == $kpiStatus3['choiseFinish']  ) {
           $tableYear = $evaluationClass->getTableYear($_POST['accept_year']);
           $score =  $evaluationClass->cpcQueryScore($_POST['accept_per_cardno'],$_POST['accept_year'],$tableYear['data'][0]['cpc_score']);
        //    echo json_encode($score);
            foreach ($score['data'] as $key => $v) {
                $result[] = $evaluationClass->cpcUpdateScoreAccept($tableYear['data'][0]['cpc_score'],$v);
            }
        

        $result[] = $evaluationClass->kpiAcceptUpdate($tableYear['data'][0]['kpi_score'],$_POST['accept_year'],$_POST['accept_per_cardno'],1);

        echo json_encode($result);
        }
}