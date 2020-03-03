<?php
session_start();
include_once '../../config.php';
include_once '../../includes/dbconn.php';
include_once "../myClass.php";

$success = array();
$db = new DbConn;
$myClass = new myClass;
$currentYear = $myClass->callYear();

$kpiScoreTable = $currentYear['data']['kpi_score'];
$personalTable = $currentYear['data']['per_personal'];
$kpiComment = $currentYear['data']['kpi_comment'];
$idpScoreTable = $currentYear['data']['idp_score'];

$success['msg'] = "";

    try{

        $sqlDelete = "DELETE FROM `$idpScoreTable` WHERE `$idpScoreTable`.`idp_id` = :idp_id  ";
        $stm = $db->conn->prepare($sqlDelete);
        $stm->bindParam(":idp_id",$_POST['idp_id']);
        $stm->execute();

        $success['success'] = true;
    }catch(Exception $e){
        $success['msg'] = $e->getMessage();
        $success['success'] = null;
    }



echo json_encode($success);
