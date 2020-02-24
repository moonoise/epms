<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";

if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4))) ){ 
    header("location:disallow.php");
  }
  $err = '';
  $success = array();

  if($_POST['new_id'] != "" ){

    try{
        $db = new dbconn;
        $sql = "UPDATE news SET new_public = IF(new_public = 1,0,1) WHERE `new_id` = :new_id";
    
        $stm = $db->conn->prepare($sql);
        $stm->bindParam(":new_id",$_POST["new_id"]);
        $stm->execute();
        
        $success['success'] = true ;
        

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