<?php
session_start();
include_once '../../config.php';
include_once '../../includes/dbconn.php';
include_once "class-person.php";

$err = "";
$success = array();
$success['msg'] = "";
$success['success'] = null;
$db = new DbConn;
try{
    
    foreach ($_POST['arrList'] as $key => $value) {
        $sql = "UPDATE ".$db->tbl_per_personal." SET head = :head WHERE per_cardno = :per_cardno ";
        $stm = $db->conn->prepare($sql);
        $stm->bindParam(":head", $_POST['per_cardno_head']);
        $stm->bindParam(":per_cardno", $value);
        $stm->execute();
        // $count = $stm->rowCount();
    }
    $success['success'] = true;

    }catch(Exception $e){
        $success['msg'] = $e->getMessage();
        $success['success'] = null;
    }

echo json_encode($success);