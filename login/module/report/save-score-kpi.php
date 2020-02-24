<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-report.php";
$success = array();
$err = '';
(strlen($_POST['kpiScore'])>0?$kpiScoreAdd = $_POST['kpiScore']:$kpiScoreAdd = null );
if ($_POST['per_cardno'] != "" || $_POST['AverageKPI'] != "" || $_POST['years'] != "" ) {
        $db = new DbConn;
        $report = new report;

        $checkKPI = $report->kpiQueryScore($_POST['per_cardno'],$_POST['years']);
        if ($checkKPI['success'] === true AND count($checkKPI['result']) == 1) {
            
            $sql = "UPDATE ".$db->tbl_kpi_score_result." SET `kpi_score_result` = :kpi_score_result,
                                                    `scoring` = :scoring  
                    WHERE `per_cardno` = :per_cardno AND `years` = :years AND soft_delete = 0 "; 
            try{
                $stm = $db->conn->prepare($sql);
                $stm->bindParam(":kpi_score_result" , $kpiScoreAdd);
                $stm->bindParam(":scoring" , $_POST['AverageKPI']);
                $stm->bindParam(":years" , $_POST['years']);
                $stm->bindParam(":per_cardno" , $_POST['per_cardno']);
    
                $stm->execute();
                
                $success['success'] = true;
                $success['msg'] = "Update.";
            }catch(Exception $e)
            {
                $err = $e->getMessage();
            }
                    
        }elseif ($checkKPI['success'] === true AND count($checkKPI['result'])  == 0) {
            $sql = "INSERT INTO ".$db->tbl_kpi_score_result." (`per_cardno`,`kpi_score_result` , `scoring` ,`years` ) 
                    VALUES (:per_cardno , :kpi_score_result , :scoring , :years ) ";
            try{
                $stm = $db->conn->prepare($sql);
                $stm->bindParam(":kpi_score_result" , $kpiScoreAdd);
                $stm->bindParam(":scoring" , $_POST['AverageKPI']);
                $stm->bindParam(":years" , $_POST['years']);
                $stm->bindParam(":per_cardno" , $_POST['per_cardno']);

                $stm->execute();
                $success['success'] = true;
                $success['msg'] = "Insert.";

            }catch(Exception $e)
            {
                $err = $e->getMessage();
            }
        }elseif ($checkKPI['success'] === true AND count($checkKPI['result'])  > 1) {
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
