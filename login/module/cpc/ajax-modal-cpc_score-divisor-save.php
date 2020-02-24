<?php

$msg = array();
if ($_POST['cpc_score_id'] != "" &&  $_POST['val_divisor'] != "" ) {
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";

    $err = '';
    try{
        $db = new DbConn;
        $sql = "UPDATE  $tbl_cpc_score SET cpc_divisor = :cpc_divisor WHERE `cpc_score_id` = :cpc_score_id ";
        $stm =   $db->conn->prepare($sql);
        $stm->bindParam(":cpc_divisor",$_POST['val_divisor']);
        $stm->bindParam(":cpc_score_id",$_POST['cpc_score_id']);
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
    $msg['msg']  = 'not found POST ';
}

echo json_encode($msg);