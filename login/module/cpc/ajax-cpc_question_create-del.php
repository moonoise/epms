<?php
if (isset($_GET['pl_name']) && isset($_GET['question_no'])) {
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    $msg = array();
    $err = '';

    try{
        $db = new DbConn;
        $sql = "DELETE FROM `cpc_question_create` WHERE `cpc_question_create`.`pl_code` = :pl_code AND  `cpc_question_create`.`question_no` = :question_no";
        $stm =  $db->conn->prepare($sql);
        $stm->bindParam(':question_no',$_GET['question_no'],PDO::PARAM_STR);
        $stm->execute();

        
    }catch(Exception $e){
        $err = $e->getMessage();
        echo $err;
    }
}