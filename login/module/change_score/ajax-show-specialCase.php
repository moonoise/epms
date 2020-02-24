<?php
 session_start();
 include_once "../../config.php";
 include_once "../../includes/dbconn.php";
include_once "../myClass.php";
include_once "../report/class-report.php";

 $success = array('success' => null,
                'result' => null,
                'msg' => null );

    try {
        $db = new DbConn;
        $myClass = new myClass;
        $report = new report;
        $tableYears = $myClass->callYear();
        
        $sql = "SELECT  t1.kpi_code,
                        CONCAT('<a href=\"view-change-score.php?per_cardno=',t2.per_cardno,'\" target= \"change_score\" >' ,t2.per_cardno,'</a>') as per_cardno_link,
                        CONCAT(t2.pn_name,t2.per_name,' ',t2.per_surname) as name,
                        t2.org_name,
                        t2.org_name1,
                        t2.org_name2,
                        t2.per_cardno
                FROM ".$tableYears['data']['kpi_score']." t1
                LEFT JOIN ".$tableYears['data']['per_personal']." t2 ON t2.per_cardno = t1.per_cardno 
                WHERE t1.kpi_code = 'rid-01' AND t1.soft_delete = 0"; 
                        
        $stm = $db->conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $key => $value) {
            $success['data'][$key] = $value;
            $checkKPI = $report->kpiQueryScore($value['per_cardno'],$tableYears['data']['table_year']);
            $checkCPC = $report->cpcQueryScore($value['per_cardno'],$tableYears['data']['table_year']);

            
            $c = $checkCPC['result'][0]['cpc_score_result_head'] * ($checkCPC['result'][0]['scoring'] /100);
            $k = $checkKPI['result'][0]['kpi_score_result'] * ($checkKPI['result'][0]['scoring'] / 100);
            $sum = round($c + $k  , 2) ;

            $success['data'][$key]['sum_CPC_KPI'] = $sum;
           
        }
        
        $success['success'] = true;
    
    } catch (\Exception $e) {
        $success['success'] = false;
        $success['msg'] = $e;
    }




echo json_encode($success);
