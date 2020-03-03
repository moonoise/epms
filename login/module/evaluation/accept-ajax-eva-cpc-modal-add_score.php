<?php
session_start();
$err = "";
$success = array();
// foreach ($_POST as $key => $value) {
//     echo $key ."->". $value ."<br>";
// }

if(isset($_POST['cpc_accept1']) and strlen($_POST['cpc_accept1']) > 0 ){ $cpc_accept1 = $_POST['cpc_accept1']; }else{ $cpc_accept1 = null; }
if(isset($_POST['cpc_accept2']) and strlen($_POST['cpc_accept2']) > 0){ $cpc_accept2 = $_POST['cpc_accept2']; }else{ $cpc_accept2 = null; }
if(isset($_POST['cpc_accept3']) and strlen($_POST['cpc_accept3']) > 0 ){ $cpc_accept3 = $_POST['cpc_accept3']; }else{ $cpc_accept3 = null; }
if(isset($_POST['cpc_accept4']) and strlen($_POST['cpc_accept4']) > 0 ){ $cpc_accept4 = $_POST['cpc_accept4']; }else{ $cpc_accept4 = null; }
if(isset($_POST['cpc_accept5']) and strlen($_POST['cpc_accept5']) > 0 ){ $cpc_accept5 = $_POST['cpc_accept5']; }else{ $cpc_accept5 = null; }

if(isset($_POST['cpc_comment1']) and strlen($_POST['cpc_comment1']) > 0 ){ $cpc_comment1 = $_POST['cpc_comment1']; }else{ $cpc_comment1 = null; }
if(isset($_POST['cpc_comment2']) and strlen($_POST['cpc_comment2']) > 0 ){ $cpc_comment2 = $_POST['cpc_comment2']; }else{ $cpc_comment2 = null; }
if(isset($_POST['cpc_comment3']) and strlen($_POST['cpc_comment3']) > 0 ){ $cpc_comment3 = $_POST['cpc_comment3']; }else{ $cpc_comment3 = null; }
if(isset($_POST['cpc_comment4']) and strlen($_POST['cpc_comment4']) > 0 ){ $cpc_comment4 = $_POST['cpc_comment4']; }else{ $cpc_comment4 = null; }
if(isset($_POST['cpc_comment5']) and strlen($_POST['cpc_comment5']) > 0 ){ $cpc_comment5 = $_POST['cpc_comment5']; }else{ $cpc_comment5 = null; }

 if (!empty($_POST['cpc_score_id']) ) {
    include_once "../../config.php";
    include_once "../../includes/dbconn.php"; 
    include_once "../cpc/class-cpc.php";
    include_once "../myClass.php";
    $cpc = new cpc;
    $myClass = new myClass;
    $currentYear = $myClass->callYear();
    $cpcScoreTable = $currentYear['data']['cpc_score'];
    
    $checkAccept = $cpc->cpcBtnStatus2($_POST['cpc_score_id'],$cpcScoreTable);
    if ($checkAccept['success'] === false) {  // ถ้ากรอกคะแนนยังไม่สมบูรณ์
        
        try{
        
        $dateNow = date("Y-m-d H:i:s");
        $who_is_accept = $_SESSION[__USER_ID__];
        $sqlUpdate = "UPDATE ".$cpcScoreTable." 
                    SET `cpc_accept1` = :cpc_accept1, 
                    `cpc_accept2` = :cpc_accept2, 
                    `cpc_accept3` = :cpc_accept3, 
                    `cpc_accept4` = :cpc_accept4, 
                    `cpc_accept5` = :cpc_accept5,
                    `cpc_comment1` = :cpc_comment1,
                    `cpc_comment2` = :cpc_comment2,
                    `cpc_comment3` = :cpc_comment3,
                    `cpc_comment4` = :cpc_comment4,
                    `cpc_comment5` = :cpc_comment5,
                    `who_is_accept` = :who_is_accept,
                    `date_who_id_accept` = :dateNow
                    WHERE ".$cpcScoreTable.".`cpc_score_id` = :cpc_score_id";
        
        $stm = $cpc->conn->prepare($sqlUpdate);
        $stm->bindParam(":cpc_accept1",$cpc_accept1);
        $stm->bindParam(":cpc_accept2",$cpc_accept2);
        $stm->bindParam(":cpc_accept3",$cpc_accept3);
        $stm->bindParam(":cpc_accept4",$cpc_accept4);
        $stm->bindParam(":cpc_accept5",$cpc_accept5);
        $stm->bindParam(":cpc_comment1",$cpc_comment1);
        $stm->bindParam(":cpc_comment2",$cpc_comment2);
        $stm->bindParam(":cpc_comment3",$cpc_comment3);
        $stm->bindParam(":cpc_comment4",$cpc_comment4);
        $stm->bindParam(":cpc_comment5",$cpc_comment5);

        $stm->bindParam(":who_is_accept",$who_is_accept);
        $stm->bindParam(":dateNow",$dateNow);
        $stm->bindParam(":cpc_score_id",$_POST['cpc_score_id']);

        $stm->execute();
        
        }catch(Exception $e)
        {
            $err = $e->getMessage();
        }
        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = $err;
        }else if ( $cpc_accept1 === null or $cpc_accept2 === null or $cpc_accept3 === null or $cpc_accept4 === null or $cpc_accept5 === null  ) {
            $success['success'] = false;
            $success['msg'] = "ยื่นยันผลประเมินไม่ครบ";
        }else {
            $success['success'] = true;
            $success['msg'] = "สำเร็จ";
        }
        
    }elseif ($checkScore['success'] === true) {
        $success['success'] = false;
         $success['msg'] = "ไม่สามารถบันทึกอีกได้  เนื่องจากบันทึกคะแนนไปแล้ว";  //can't update ,because eavaluation finish. 
    }
}else {
    $success['success'] = null;
    $success['msg'] = "POST Error";
}

echo  json_encode($success)  ;