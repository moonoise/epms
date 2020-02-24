<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";

if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4))) ){ 
    header("location:disallow.php");
  }
  $err = '';
  $success = array();
if($_POST['id_new'] != "" ){

    try{
        $db = new dbconn;
        $sql = "SELECT * FROM `news` WHERE new_id = :id_new ";
    
        $stm = $db->conn->prepare($sql);
        $stm->bindParam(":id_new",$_POST["id_new"]);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        
        $success['success'] = true ;
        $success['result'] = $result[0];

    }catch(Exception $e)
    {
        $success['success'] = null;
        $success['msg'] = $e->getMessage();

    }   

    
}else{
    $success['success'] = null;
    $success['msg'] = "POST not found.";
}

echo json_encode($success);

?>