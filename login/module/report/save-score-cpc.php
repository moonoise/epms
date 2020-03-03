<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-report.php";
include_once "../myClass.php";
$success = array();
$err = '';

$db = new DbConn;
$report = new report;
$myClass = new myClass;
$currentYear = $myClass->callYear();
$cpcScoreResult = $currentYear['data']['cpc_score_result'];
$checkCPC = $report->cpcQueryScore($_POST['per_cardno'],$_POST['years'],$cpcScoreResult);

(strlen($_POST['cpcScore'])>0?$cpcScoreAdd = $_POST['cpcScore']:$cpcScoreAdd = null );
if ($_POST['per_cardno'] != "" || $_POST['AverageCPC'] != "" || $_POST['years'] != "" ) {
 
        if ($checkCPC['success'] === true AND count($checkCPC['result']) == 1) {
            
            $sql = "UPDATE $cpcScoreResult SET `cpc_score_result_head` = :cpc_score_result_head,
                                                    `scoring` = :scoring  
                    WHERE `per_cardno` = :per_cardno AND `years` = :years AND soft_delete = 0 "; 
            try{
               
                $stm = $db->conn->prepare($sql);
                $stm->bindParam(":cpc_score_result_head" , $cpcScoreAdd);
                $stm->bindParam(":scoring" , $_POST['AverageCPC']);
                $stm->bindParam(":years" , $_POST['years']);
                $stm->bindParam(":per_cardno" , $_POST['per_cardno']);
    
                $stm->execute();
                
                $success['success'] = true;
                $success['msg'] = "Update.";
            }catch(Exception $e)
            {
                $err = $e->getMessage();
            }
                    
        }elseif ($checkCPC['success'] === true AND count($checkCPC['result'])  == 0) {
            $sql = "INSERT INTO $cpcScoreResult (`per_cardno`,`cpc_score_result_head` , `scoring` ,`years` ) 
                    VALUES (:per_cardno , :cpc_score_result_head , :scoring , :years ) ";
            try{
                
                $stm = $db->conn->prepare($sql);
                $stm->bindParam(":cpc_score_result_head" , $cpcScoreAdd);
                $stm->bindParam(":scoring" , $_POST['AverageCPC']);
                $stm->bindParam(":years" , $_POST['years']);
                $stm->bindParam(":per_cardno" , $_POST['per_cardno']);

                $stm->execute();
                $success['success'] = true;
                $success['msg'] = "Insert.";

            }catch(Exception $e)
            {
                $err = $e->getMessage();
            }
        }elseif ($checkCPC['success'] === true AND count($checkCPC['result'])  > 1) {
            $success['success'] = false;
            $success['msg'] = "พบข้อมูลผิดพลาด มีข้อมูลมากว่า 1  เรกคอร์ด";
        }
       
        
        if ($err != '') {
            $success['success'] = null;
            $success['msg'] = $err . $sql;
        }
        
}else {
    $success['success'] = null;
    $success['msg'] = "POST Error.";

}

echo json_encode($success) ;


?>

