<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";

$success = array('success' => null ,
               'msg' => null,
              'result' => null );
try{
    $db = new DbConn;
    $sql = "SELECT *
                FROM `kpi_question` 
            WHERE `kpi_code` = :kpi_code"; 
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(":kpi_code" , $_POST['kpi_code']);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    $success['success'] = true;
    $success['result'] = $result;
}catch(Exception $e){
    $success['msg'] = $e->getMessage();
    $success['success'] = null;
}


echo json_encode($success);