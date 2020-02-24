<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";


$db = new DbConn;

$err = "";
$success = array();

try{

    $sql2 = "SELECT `config_value` FROM  `config` WHERE `config_name` = 'evaluation_on_off' " ;
    $stm2 = $db->conn->prepare($sql2);
    $stm2->execute();
    $result = $stm2->fetchAll();
    $count = $stm2->rowCount();

    if ($count == 1) {
        $success['success'] = true;   
        $success['result'] = $result[0]['config_value']; 
    }else{
        $success['success'] = false;
        $success['msg'] = "not found .";
    }    
}catch(Exception $e){
    $err = $e->getMessage();
}
if($err != ""){
    $success['success'] = null;
    $success['msg'] = $err;
}

echo json_encode($success);
?>