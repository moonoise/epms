<?php
session_start();
include_once '../../config.php';
include_once '../../includes/dbconn.php';
include_once "../myClass.php";

$success = array();
$db = new DbConn;
$success['msg'] = "";

$myClass = new myClass;
$currentYear = $myClass->callYear();

$kpiScoreTable = $currentYear['data']['kpi_score'];
$personalTable = $currentYear['data']['per_personal'];
$kpiComment = $currentYear['data']['kpi_comment'];
$idpScoreTable = $currentYear['data']['idp_score'];

if ($_POST['hiden_idp_id'] != "") {
    try{

        $sqlUpdate = "UPDATE $idpScoreTable SET `idp_title` = :idp_title ,
        `idp_training_method` = :idp_training_method,
        `idp_training_hour` = :idp_training_hour 
        WHERE `idp_id` =  :idp_id ";
        $stm = $db->conn->prepare($sqlUpdate);
        $stm->bindParam(":idp_title",$_POST['idp_title']);
        $stm->bindParam(":idp_training_method",$_POST['idp_training_method']);
        $stm->bindParam(":idp_training_hour",$_POST['idp_training_hour']);
        $stm->bindParam(":idp_id",$_POST['hiden_idp_id']);
        $stm->execute();

        $success['success'] = true;
    }catch(Exception $e){
        $success['msg'] = $e->getMessage();
    }

    
}else {
    try{

        $sqlInsert = "INSERT INTO $idpScoreTable (`idp_id` , `per_cardno` , `years` ,`idp_type` , `idp_title`, `idp_training_method` ,`idp_training_hour`,`cpc_score_id`,`question_no`) 
                    VALUES (NULL, :per_cardno ,:years ,:idp_type , :idp_title , :idp_training_method ,:idp_training_hour , :cpc_score_id , :question_no ) ";
        $stm = $db->conn->prepare($sqlInsert);
        
        $stm->bindParam(":per_cardno",$_POST['hiden_per_cardno']);
        $stm->bindParam(":years",$_POST['hiden_years']);
        $stm->bindParam(":idp_type",$_POST['hiden_idp_type']);
        $stm->bindParam(":idp_title",$_POST['idp_title']);
        $stm->bindParam(":idp_training_method",$_POST['idp_training_method']);
        $stm->bindParam(":idp_training_hour",$_POST['idp_training_hour']);
        $stm->bindParam(":cpc_score_id",$_POST['hiden_cpc_score_id']);
        $stm->bindParam(":question_no",$_POST['hiden_question_no']);
        $stm->execute();

        $success['success'] = true;
    }catch(Exception $e){
        $success['msg'] = $e->getMessage();
    }


}

echo json_encode($success);
