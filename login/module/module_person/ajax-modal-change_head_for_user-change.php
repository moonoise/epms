<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";

    $err = "";
    $success = array();
    $success['msg'] = "";
    try{
    $db = new DbConn;

    $sql = "UPDATE ".$db->tbl_per_personal." SET head = :per_cardno_head WHERE per_cardno = :per_cardno_user";
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
