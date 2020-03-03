<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../myClass.php";
$db = new DbConn;
$success = array();
$test = "";
$myClass = new myClass;
$currentYear = $myClass->callYear();
$cpc_score = $currentYear['data']['cpc_score'];
// echo "<pre>";
// print_r($_POST['cpc_score_id']);
// echo "</pre>";
// $success['success'] = $_POST['cpc_score_id'][];
if(!empty($_POST['cpc_score_id'])){
    $text = array_filter($_POST['cpc_score_id']);
    $sqlIN = implode(",",$text);
   
    if ($_POST['typeClear'] == 1) {
        $sql = "UPDATE $cpc_score SET 
                cpc_score1 = null ,
                cpc_score2 = null ,
                cpc_score3 = null ,
                cpc_score4 = null ,
                cpc_score5 = null ,
                cpc_accept1 = null ,
                cpc_accept2 = null ,
                cpc_accept3 = null ,
                cpc_accept4 = null ,
                cpc_accept5 = null ,
                cpc_comment1 = null,
                cpc_comment2 = null,
                cpc_comment3 = null,
                cpc_comment4 = null,
                cpc_comment5 = null
                WHERE  cpc_score_id IN ($sqlIN) ";
    }elseif ($_POST['typeClear'] == 2) {
        $sql = "UPDATE $cpc_score SET 
                cpc_accept1 = null ,
                cpc_accept2 = null ,
                cpc_accept3 = null ,
                cpc_accept4 = null ,
                cpc_accept5 = null ,
                cpc_comment1 = null,
                cpc_comment2 = null,
                cpc_comment3 = null,
                cpc_comment4 = null,
                cpc_comment5 = null
                WHERE  cpc_score_id IN ($sqlIN) ";
    }
    
    $stm = $db->conn->prepare($sql);
    $stm->execute();
    
    // if ( $stm->rowCount() > 0) {
    //     $success['success'] = true;
    // }else {
    //     $success['success'] = false;
    // }
    $success['success'] = true;
}else{
    $success['success'] = false;
}


echo json_encode($success);
?>