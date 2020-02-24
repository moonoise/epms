<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";

$success = array('success' => null ,
               'msg' => null );
try{
    $db = new DbConn;
    $sql = "UPDATE `kpi_question` SET  `kpi_status` = IF(`kpi_status` = 1 , 0 , 1)  WHERE `kpi_code` = :kpi_code "; 
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(":kpi_code" , $_POST['kpi_code']);
    $stm->execute();
    
    $success['success'] = true;
    
}catch(Exception $e){
    $success['msg'] = $e->getMessage();
    $success['success'] = null;
}


echo json_encode($success);