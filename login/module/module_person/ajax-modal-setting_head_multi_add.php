<?php
session_start();
include_once '../../config.php';
include_once '../../includes/dbconn.php';
include_once "class-person.php";
include_once "../myClass.php";


$err = "";
$success = array();
$success['msg'] = "";
$success['success'] = null;
$db = new DbConn;
$myClass = new myClass;
$currentYear = $myClass->callYear();
$personalTable = $currentYear['data']['per_personal'];
try{
    
    foreach ($_POST['arrList'] as $key => $value) {
        $sql = "UPDATE $personalTable SET head = :head WHERE per_cardno = :per_cardno ";
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