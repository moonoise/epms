<?php
session_start();

if (!empty($_GET['cpc_score_id'])) {
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "class-cpc.php";
    include_once "../myClass.php";
   
    $cpc = new cpc;
    $err = '';
    $success = array();

    $myClass = new myClass;
    $currentYear = $myClass->callYear();
    $cpc_score = $currentYear['data']['cpc_score'];
    try
    {
        $sql = "DELETE FROM $cpc_score WHERE cpc_score_id = :cpc_score_id";
        $stm = $cpc->conn->prepare($sql);
        $stm->bindParam(":cpc_score_id",$_GET['cpc_score_id']);

       if ($stm->execute()) {
        $s = true;     
       } else {
        $s = false;
       }
        
        
    }catch(Exception $e)
    {
        $err = $e->getMessage();
    }

    if ($err != '') 
    {
        $success['success'] = null;
        $success['msg'] = 'การลบ -> '.$err;
    }else 
    {
        $success['success'] = $s;
        $success['msg'] = 'true is delete ok  ||  false is not found record.';
    }

}else {
    $success['success'] = null;
    $success['msg'] = 'not found GET value.';
}
echo json_encode($success);