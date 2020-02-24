<?php
$msg = array();
if (!empty($_GET['qc_id'])) {
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";

    $err = '';
    try{
        $db = new DbConn;
        $sql = "DELETE FROM `cpc_question_create` WHERE `cpc_question_create`.`qc_id` = :qc_id";
        $stm =   $db->conn->prepare($sql);
        $stm->bindParam(":qc_id",$_GET['qc_id']);
        $stm->execute();
        
    }catch(PDOException $e){
        $err = $e->getMessage();
    }
    if ($err!='') {
        $msg['success'] = false;
        $msg['msg']  = $e->getMessage();
    }else {
        $msg['success'] = true;
    }

}else {
    $msg['success'] = false;
    $msg['msg']  = 'error-01';
}

echo json_encode($msg);