<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";

if(!(isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4))) ){ 
    header("location:disallow.php");
  }
  $err = '';
  $success = array();
if($_POST['formSubmission'] != "" && $_POST['new_title'] != "" ){

    try{
        $db = new dbconn;
        $d = date("Y-m-d H:i:s");
        if($_POST['id_news'] == ""){
            $sql = "INSERT INTO news (`new_title`,`new_content`,`new_modify_date`,`new_order`) 
                        select :new_title,:new_content,:new_modify_date,(MAX(new_order)+1) as n FROM news";
        }elseif ($_POST['id_news'] != "") {
            $sql = "UPDATE news 
                    set `new_title` = :new_title , 
                        `new_content` = :new_content , 
                        `new_modify_date` = :new_modify_date 
                    WHERE `new_id` = ".$_POST['id_news'];
        }
    
        $stm = $db->conn->prepare($sql);
        $stm->bindParam(":new_title",$_POST["new_title"]);
        $stm->bindParam(":new_content",$_POST['formSubmission']);
        $stm->bindParam(":new_modify_date",$d);
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