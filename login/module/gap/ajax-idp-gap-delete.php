<?php
session_start();
include_once '../../config.php';
include_once '../../includes/dbconn.php';

$success = array();
$db = new DbConn;
$success['msg'] = "";

    try{

        $sqlDelete = "DELETE FROM ".$db->tbl_idp_score." WHERE ".$db->tbl_idp_score.".`idp_id` = :idp_id  ";
        $stm = $db->conn->prepare($sqlDelete);
        $stm->bindParam(":idp_id",$_POST['idp_id']);
        $stm->execute();

        $success['success'] = true;
    }catch(Exception $e){
        $success['msg'] = $e->getMessage();
        $success['success'] = null;
    }



echo json_encode($success);
