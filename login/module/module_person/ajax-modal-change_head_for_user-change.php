<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../myClass.php";

    $err = "";
    $success = array();
    $success['msg'] = "";
    try{
    $db = new DbConn;
    $myClass = new myClass;
    $currentYear = $myClass->callYear();
    $personalTable = $currentYear['data']['per_personal'];

    $sql = "UPDATE $personalTable SET head = :per_cardno_head WHERE per_cardno = :per_cardno_user";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(":per_cardno_head", $_POST['per_cardno_head']);
    $stm->bindParam(":per_cardno_user", $_POST['per_cardno_user']);
    $stm->execute();
    $count = $stm->rowCount();
    if(count($count == 1) ){
        $success['success'] = true;
    }else{
        $success['success'] = false;
        $success['msg'] = "count = ".$count;
    }

    }catch(Exception $e){
        $success['success'] = null;
        $success['msg'] = $e->getMessage();
    }
    echo json_encode($success);
