<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../report/class-report.php";

$db = new DbConn;
$report =  new report;

$years = $_POST['years'];
$orgSelect = $_POST['org_id'];

$errYears = "";
$errPer_cardno = "";
$per_cardnoResult  = array();
$org_percardno = array();
$r = array();

try {
    $sql_years = "SELECT * FROM `table_year` WHERE `table_year`.`table_id` = :years ";
    $stmYears = $db->conn->prepare($sql_years);
    $stmYears->bindParam(':years',$years);
    $stmYears->execute();
    $resultYears = $stmYears->fetchAll(PDO::FETCH_ASSOC);
    
} catch (\Exception $e) {
    $success['msg'] = $e->getMessage();
}

try {
    $sql2 = "select org_id,org_name from per_org where org_id = :org_id" ;
    $stm2 = $db->conn->prepare($sql2);

    $stm2->bindParam(':org_id',$orgSelect);
    $stm2->execute();
    $result2 = $stm2->fetchAll(PDO::FETCH_ASSOC);
    if(count($result2) > 0){
        $orgOutput[] = $result2[0];
        
    }

} catch (\Exception $e) {
    $success['msg'] = $e->getMessage();
}


try {
    $sql = "select * from per_org where org_id_ref = :org_id_ref" ;
    $stm = $db->conn->prepare($sql);
 
    $stm->bindParam(':org_id_ref',$orgSelect);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    if(count($result) > 0) {
        foreach ($result as $key => $value) {
            $orgOutput[] = $value;
           
        }
    }

} catch (\Exception $e) {
    $success['msg'] = $e->getMessage();
}

foreach ($orgOutput as $orgKey => $orgValue) {

    if ($orgSelect == '77') {
        
                $sql = "select per_cardno from ".$resultYears[0]['per_personal']." where  org_id = :org_id AND login_status = 1 ";
                $stm = $db->conn->prepare($sql);
                $stm->bindParam(':org_id',$orgValue['org_id']);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_COLUMN);
                if (count($result) > 0) {
                    $per_cardnoResult = $result;
                }
        
    }else {
        $sql2 = "select per_cardno from ".$resultYears[0]['per_personal']." where  org_id_2 = :org_id AND login_status = 1 ";
        $stm2 = $db->conn->prepare($sql2);
        $stm2->bindParam(':org_id',$orgValue['org_id']);
        $stm2->execute();
        $result2 = $stm2->fetchAll(PDO::FETCH_COLUMN);

        if (count($result2) > 0) {
            $per_cardnoResult = $result2;
        }else {
            $sql1 = "select per_cardno from ".$resultYears[0]['per_personal']." where  org_id_1 = :org_id AND login_status = 1";
            $stm1 = $db->conn->prepare($sql1);
            $stm1->bindParam(':org_id',$orgValue['org_id']);
            $stm1->execute();
            $result1 = $stm1->fetchAll(PDO::FETCH_COLUMN);
            if (count($result1) > 0 ) {
                $per_cardnoResult = $result1;
            }else {
                $sql = "select per_cardno from ".$resultYears[0]['per_personal']." where  org_id = :org_id  and org_id_1 is null and org_id_2 is null AND login_status = 1";
                $stm = $db->conn->prepare($sql);
                $stm->bindParam(':org_id',$orgValue['org_id']);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_COLUMN);
                if (count($result) > 0) {
                    $per_cardnoResult = $result;
                }
            }
        }
    } //else

    $org_percardno['per_cardno'] = $per_cardnoResult;
    $org_percardno['org_id'] = $orgValue['org_id'];
    $org_percardno['org_name'] = $orgValue['org_name'];

    $r[] = $org_percardno;
    $per_cardnoResult = [];
}

foreach ($r as $cardnoKey => $cardnoValue) {
    // $rr[] = $cardnoValue;
    $rr[$cardnoKey] = $report->percent_complete($cardnoValue['per_cardno'],$resultYears[0]['cpc_score_result'],$resultYears[0]['kpi_score_result'],$resultYears[0]['table_year']);
    $rr[$cardnoKey]['org_id'] = $cardnoValue['org_id'];
    $rr[$cardnoKey]['org_name'] = $cardnoValue['org_name'];
}


echo json_encode($rr);