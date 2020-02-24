<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";

$success = array('success' => null ,
               'msg' => null,
              'result' => null );
try{
    $db = new DbConn;
    $sql = "SELECT `kpi_code`,`kpi_code_org`
                FROM `kpi_question` 
            WHERE `kpi_code` = :kpi_code"; 
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(":kpi_code" , $_POST['kpi_code_new']);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) > 0 ) {
        $success['result'] = false;
    }elseif (count($result) === 0 ) {
        $success['result'] = true;
    }
     
    $success['success'] = true;
    
}catch(Exception $e){
    $success['msg'] = $e->getMessage();
    $success['success'] = null;
}


echo json_encode($success);