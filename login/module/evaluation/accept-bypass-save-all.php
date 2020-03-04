<?php 
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once '../../module/cpc/class-cpc.php';
include_once '../../module/kpi/class-kpi.php';
include_once "class-evaluation.php";
include_once "../myClass.php";


$kpi = new kpi;
$cpc = new cpc;
$evaluationClass = new evaluation;
$myClass = new myClass;
$currentYear = $myClass->callYear();
$cpcScoreTable = $currentYear['data']['cpc_score'];
$kpiScoreTable = $currentYear['data']['kpi_score'];
$year = $currentYear['data']['table_year'];
$kpiScoreCommentTable = $currentYear['data']['kpi_comment'];
$kpiResult = array("success" => "",
                    "result" => "",
                    "msg" => "");
$cpcResult = array("success" => "",
                    "result" => "",
                    "msg" => "");


// 3930100498198

$cpcStatus3 = $cpc->cpcStatus3($_POST['accept_per_cardno'],$year,$cpcScoreTable );
$kpiStatus3 = $kpi->kpiStatus3($_POST['accept_per_cardno'],$year,$kpiScoreTable );

if ($cpcStatus3['total_choise'] > 0 && $kpiStatus3['total_choise'] > 0) {
    if ( ($cpcStatus3['total_choise'] == $cpcStatus3['choiseFinish'] ) && $kpiStatus3['total_choise'] == $kpiStatus3['choiseFinish']  ) {

           $score =  $evaluationClass->cpcQueryScore($_POST['accept_per_cardno'],$year,$cpcScoreTable);
        //    echo json_encode($score);
            foreach ($score['data'] as $key => $v) {
                $result[] = $evaluationClass->cpcUpdateScoreAccept($cpcScoreTable,$v);
            }
        $result[] = $evaluationClass->kpiAcceptUpdate($kpiScoreTable,$kpiScoreCommentTable,$year,$_POST['accept_per_cardno'],1);
        echo json_encode($result);
        
        }
}

// echo json_encode($cpcStatus3);