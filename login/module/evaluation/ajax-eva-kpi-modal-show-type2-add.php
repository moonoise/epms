<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../kpi/class-kpi.php";
include_once "../myClass.php";
$err = '';
$success = array();
$kpi = new kpi;
$myClass = new myClass;
$currentYear = $myClass->callYear();
$kpiScoreTable = $currentYear['data']['kpi_score'];
$per_personalTable = $currentYear['data']['per_personal'];
$kpiComment = $currentYear['data']['kpi_comment'];
// foreach ($_POST as $key => $value) {
//     echo $key ."->". $value ."<br>";
// }
$success['success'] = "";
$success['msg'] = "";
if(isset($_POST['works_name']) and strlen($_POST['works_name'])>0 ){ $works_name = $_POST['works_name']; }else{ $works_name = null; }

if (!empty($_POST['kpi_score_id']) && !empty($_POST['kpi_code']) ) {
    
                try{
                    if (is_numeric($_POST['modal_kpi_score_raw'])) {
                        $s = $kpi->processScoreType2($_POST['kpi_code'],$_POST['modal_kpi_score_raw']);
                        if ($s['success'] === true or $s['success'] === false) {
                            $ss = round($s['result'], 2);  //แปลงทศนิยมให้เหลือ 2 ตำแหน่ง

                            $sql = "UPDATE $kpiScoreTable SET `kpi_score_raw` = :modal_kpi_score_raw,
                                                            `kpi_score` = :kpi_score
                                                            WHERE `kpi_score_id` = :kpi_score_id 
                                                            AND (`kpi_accept` <> 1 OR `kpi_accept` IS NULL)";
                            $stm = $kpi->conn->prepare($sql);
                            $stm->bindParam(":modal_kpi_score_raw",$_POST['modal_kpi_score_raw']);
                            $stm->bindParam(":kpi_score", $ss);
                            
                            $stm->bindParam(":kpi_score_id",$_POST['kpi_score_id']);
                            $stm->execute();
                            $count = $stm->rowCount();
                            if ($count == 0) {
                                $success['success_score'] = false;
                                $success['msg_score'] = "";
                            }else {
                                $success['success_score'] = true;
                                $success['msg_score'] = "บันทึกคะแนนแล้ว";
                            }

                        }else {
                            $success['success_score'] = null;
                            $success['msg_score'] = $s['msg'];
                            
                        }

                    }else {
                        $success['success_score'] = false;
                        $success['msg_score'] = "ต้องเป็นตัวเลข 1-100 เท่านั้น";
                    }

                    $sql = "UPDATE $kpiScoreTable SET `works_name` = :works_name
                            WHERE `kpi_score_id` = :kpi_score_id ";
                    $stm = $kpi->conn->prepare($sql);
                    $stm->bindParam(":works_name",$works_name);
                    $stm->bindParam(":kpi_score_id",$_POST['kpi_score_id']);
                    $stm->execute();
                    $count = $stm->rowCount();
                    if ($count == 0) {
                        $success['success_workName'] = false;
                        $success['msg_workName'] = "";
                    }else {
                        $success['success_workName'] = true;
                        $success['msg_workName'] = "บันทึกชื่อผลงานแล้ว";
                    }
                
                
                }catch(Exception $e)
                {
                    $err = $e->getMessage();
                    $success['success'] = null;
                    $success['msg'] = $err;
                }
        

   
}else {
    $success['success'] = null;
    $success['msg'] = "POST variable not found.";
}

echo json_encode($success);



