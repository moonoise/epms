<?php
$err = "";
$success = array();
// foreach ($_POST as $key => $value) {
//     echo $key ."->". $value ."<br>";
// }

if(isset($_POST['cpc_score1']) and strlen($_POST['cpc_score1']) > 0 ){ $cpc_score1 = $_POST['cpc_score1']; }else{ $cpc_score1 = null; }
if(isset($_POST['cpc_score2']) and strlen($_POST['cpc_score2']) > 0 ){ $cpc_score2 = $_POST['cpc_score2']; }else{ $cpc_score2 = null; }
if(isset($_POST['cpc_score3']) and strlen($_POST['cpc_score3']) > 0 ){ $cpc_score3 = $_POST['cpc_score3']; }else{ $cpc_score3 = null; }
if(isset($_POST['cpc_score4']) and strlen($_POST['cpc_score4']) > 0 ){ $cpc_score4 = $_POST['cpc_score4']; }else{ $cpc_score4 = null; }
if(isset($_POST['cpc_score5']) and strlen($_POST['cpc_score5']) > 0 ){ $cpc_score5 = $_POST['cpc_score5']; }else{ $cpc_score5 = null; }

 if (!empty($_POST['cpc_score_id']) ) {
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    include_once "../cpc/class-cpc.php";
    include_once "../myClass.php";

    $cpc = new cpc;
    $myClass = new myClass;
    $currentYear = $myClass->callYear();
    $cpcScoreTable = $currentYear['data']['cpc_score'];

    $checkScore = $cpc->cpcBtnStatus1($_POST['cpc_score_id'],$cpcScoreTable);
    if ($checkScore['success'] === false) {  // ถ้ากรอกคะแนนยังไม่สมบูรณ์
        try{
        $dateNow = date("Y-m-d H:i:s");
        $sqlUpdate = "UPDATE `$cpcScoreTable` 
                    SET `cpc_score1` = :cpc_score1, 
                    `cpc_score2` = :cpc_score2, 
                    `cpc_score3` = :cpc_score3, 
                    `cpc_score4` = :cpc_score4, 
                    `cpc_score5` = :cpc_score5,
                    `date_key_score` = :dateNow
                    WHERE `$cpcScoreTable`.`cpc_score_id` = :cpc_score_id";
        
        $stm = $cpc->conn->prepare($sqlUpdate);
        $stm->bindParam(":cpc_score1",$cpc_score1);
        $stm->bindParam(":cpc_score2",$cpc_score2);
        $stm->bindParam(":cpc_score3",$cpc_score3);
        $stm->bindParam(":cpc_score4",$cpc_score4);
        $stm->bindParam(":cpc_score5",$cpc_score5);
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
        }else if ( $cpc_score1 === null or $cpc_score2 === null or $cpc_score3 === null or $cpc_score4 === null or $cpc_score5 === null  ) {
            $success['success'] = false;
            $success['msg'] = "ยังทำประเมินไม่ครบ";
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