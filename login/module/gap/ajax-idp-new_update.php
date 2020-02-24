<?php
session_start();
include_once '../../config.php';
include_once '../../includes/dbconn.php';

$success = array();
$db = new DbConn;
$success['msg'] = "";

if ($_POST['new_idp_id'] == "") {
    try{
        $sql = "INSERT INTO ".$db->tbl_idp_score." (`idp_id` , `per_cardno` , `years` ,
                                     `idp_type` , `idp_type_detail` ,`idp_title` ,`idp_training_method` ,
                                     `idp_training_hour` ,`question_no` ) 
                VALUES (NULL , :per_cardno , :years ,
                        :idp_type , :idp_type_detail , :idp_title , :idp_training_method ,
                        :idp_training_hour , :question_no ) ";
        ($_POST['hidden_new_idp_cpcType']==""?$cpcType=NULL:$cpcType=$_POST['hidden_new_idp_cpcType']);
         $stm = $db->conn->prepare($sql);
         $stm->bindParam(":per_cardno",$_POST['new_per_cardno']);
         $stm->bindParam(":years",$_POST['new_years']);
         $stm->bindParam(":idp_type",$cpcType);
         $stm->bindParam(":idp_type_detail",$_POST['new_idp_type_detail']);
         $stm->bindParam(":idp_title",$_POST['new_idp_title']);
         $stm->bindParam(":idp_training_method",$_POST['new_idp_training_method']);
         $stm->bindParam(":idp_training_hour",$_POST['new_idp_training_hour']);
         $stm->bindParam(":question_no",$_POST['new_question_no']);
        
         $stm->execute();

        $success['success'] = true;

    }catch(Exception $e){
        $success['msg'] = $e->getMessage();
        $success['success'] = null;
    }


}else {
    
    try{
        $sqlUpdate = "UPDATE ".$db->tbl_idp_score." SET  `idp_type` = :idp_type,
                                             `idp_type_detail` = :idp_type_detail, 
                                             `idp_title` = :idp_title,
                                             `idp_training_method` = :idp_training_method,
                                             `idp_training_hour` = :idp_training_hour,
                                             `question_no` = :question_no
                     WHERE `idp_id` = :idp_id  AND `per_cardno` = :per_cardno AND `years` = :years " ;
        ($_POST['hidden_new_idp_cpcType']==""?$cpcType=NULL:$cpcType=$_POST['hidden_new_idp_cpcType']);
        $stm = $db->conn->prepare($sqlUpdate);
        $stm->bindParam(":idp_type",$cpcType);
        $stm->bindParam(":idp_type_detail",$_POST['new_idp_type_detail']);
        $stm->bindParam(":idp_title",$_POST['new_idp_title']);
        $stm->bindParam(":idp_training_method",$_POST['new_idp_training_method']);
        $stm->bindParam(":idp_training_hour",$_POST['new_idp_training_hour']);
        $stm->bindParam(":question_no",$_POST['new_question_no']);

        $stm->bindParam(":idp_id",$_POST['new_idp_id']);
        $stm->bindParam(":per_cardno",$_POST['new_per_cardno']);
        $stm->bindParam(":years",$_POST['new_years']);

        $stm->execute();

        $success['success'] = true;

    }catch(Exception $e){
        $success['msg'] = $e->getMessage();
    
        $success['success'] = null;
    }

}

echo json_encode($success);