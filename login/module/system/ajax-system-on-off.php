<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";


$db = new DbConn;

$err = "";
$success = array();

try{
    $sql =  "UPDATE `config` SET `config_value` = IF(`config_value` = 1,0,1) WHERE `config_name` = 'evaluation_on_off' ";
    $stm = $db->conn->prepare($sql);
    $stm->execute();

        $success['success'] = true;   
     
}catch(Exception $e){
    $err = $e->getMessage();
}
if($err != ""){
    $success['success'] = null;
    $success['msg'] = $err;
}

echo json_encode($success);
?>