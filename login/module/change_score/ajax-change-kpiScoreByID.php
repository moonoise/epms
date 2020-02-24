<?php
 session_start();
 include_once "../../config.php";
 include_once "../../includes/dbconn.php";
include_once "../myClass.php";

 $success = array('success' => null,
                'result' => null,
                'msg' => null );

$d = date("Y-m-d H:i:s");
$who_is_accept = $_SESSION[__USER_ID__];
$date_key_score = $d;
$date_who_id_accept = $d;

    try {
        $db = new DbConn;
        $myClass = new myClass;
        $tableYears = $myClass->callYear();
    
        $sql = "UPDATE ".$tableYears['data']['kpi_score']." SET 
                    kpi_score = :s , 
                    kpi_accept = 1 ,
                    who_is_accept = :who_is_accept,
                    date_key_score = :date_key_score,
                    date_who_id_accept = :date_who_id_accept 
                    WHERE kpi_score_id = :kpi_score_id ";
        $stm = $db->conn->prepare($sql);
        $stm->bindParam(":s" , $_POST['score']);
        $stm->bindParam(":who_is_accept" , $who_is_accept);
        $stm->bindParam(":date_key_score" , $date_key_score);
        $stm->bindParam(":date_who_id_accept" , $date_who_id_accept);
        $stm->bindParam(":kpi_score_id" , $_POST['kpi_score_id']);
        $stm->execute();
    
        $success['success'] = true;
    
    } catch (\Exception $e) {
        $success['success'] = false;
        $success['msg'] = $e;
    }


echo json_encode($success);