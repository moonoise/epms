<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-person.php";

$db = new DbConn;

$err = "";
$success = array();

try{
    $sql =  "UPDATE ".$tbl_per_personal." SET login_status = IF(login_status = 1,0,1) WHERE `per_cardno` = :per_cardno";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(':per_cardno',$_POST['per_cardno']);
    $stm->execute();

    $sql2 = "SELECT `login_status` FROM  ".$tbl_per_personal." WHERE `per_cardno` = :per_cardno " ;
    $stm2 = $db->conn->prepare($sql2);
    $stm2->bindParam(':per_cardno',$_POST['per_cardno']);
    $stm2->execute();
    $result = $stm2->fetchAll();
    $count = $stm2->rowCount();

    if ($count == 1) {
        $success['success'] = true;   
        $success['result'] = $result[0]['login_status']; 
    }else{
        $success['success'] = false;
        $success['msg'] = "ไม่พบข้อมูลของผู้ระงับการใช้งาน";
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
