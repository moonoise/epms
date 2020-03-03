<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../myClass.php";


if(!empty($_POST['per_cardno']) && !empty($_POST['head']))
{
    $err = "";
    $success = array();
    try{
    $db = new DbConn;
    $myClass = new myClass;
    $currentYear = $myClass->callYear();
    $personalTable = $currentYear['data']['per_personal'];

    $sql = "UPDATE $personalTable SET head = :head WHERE per_cardno = :per_cardno ";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(":head", $_POST['head']);
    $stm->bindParam(":per_cardno", $_POST['per_cardno']);
    $stm->execute();
    $count = $stm->rowCount();

    }catch(Exception $e){
        $err = $e->getMessage();
    }
// echo $sql;
    if ($count == 1) {
        $success['success'] = true;
    }else {
        $success['success'] = false;
        $success['msg'] = $err . " count = ".$count;
    }

    echo json_encode($success);
}