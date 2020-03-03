<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../kpi/class-kpi.php";
include_once "../myClass.php";
$err = '';
$success = array();
$count = "";
 
$kpi = new kpi;
$myClass = new myClass;
$currentYear = $myClass->callYear();
$kpiScoreTable = $currentYear['data']['kpi_score'];
$per_personalTable = $currentYear['data']['per_personal'];
$kpiComment = $currentYear['data']['kpi_comment'];
// foreach ($_POST as $key => $value) {
//     echo $key ."->". $value ."<br>";
// }

if(isset($_POST['kpi_accept']) and strlen($_POST['kpi_accept']) > 0 ){ $kpi_accept = $_POST['kpi_accept']; }else{ $kpi_accept = null; }
if(isset($_POST['kpi_comment']) and strlen($_POST['kpi_comment']) > 0 ){ $kpi_comment = $_POST['kpi_comment']; }else{ $kpi_comment = null; }

if (!empty($_POST['kpi_score_id'])) {
   
        $checkScore = $kpi->kpiBtnStatus1($_POST['kpi_score_id'],$kpiScoreTable);
        $checkAccept = $kpi->kpiBtnStatus2($_POST['kpi_score_id'],$kpiScoreTable);
        if ($checkScore['success']== true && $checkAccept['success'] == false) {

            try{
                $date_who_id_accept = date("Y-m-d H:i:s");
                $who_is_accept =  $_SESSION[__USER_ID__];

                if ($kpi_accept == 1) {
                        $sql = "UPDATE $kpiScoreTable SET `kpi_accept` = :kpi_accept,
                                        
                                        `who_is_accept` = :who_is_accept,
                                        `date_who_id_accept` = :date_who_id_accept 
                                WHERE `$kpiScoreTable`.`kpi_score_id` = :kpi_score_id ";
                        $stm = $kpi->conn->prepare($sql);
                        $stm->bindValue(":kpi_accept",1);
                        $stm->bindParam(":who_is_accept",$who_is_accept);
                        $stm->bindParam(":date_who_id_accept",$date_who_id_accept);
                        $stm->bindParam(":kpi_score_id",$_POST['kpi_score_id']);
                        $stm->execute();
                        $count = $stm->rowCount();
                        if ($count == 0) {
                            $success['success'] = false;
                            $success['msg'] = "Data not update.";
                        }else {
                            $success['success'] = true;
                            $success['msg'] = "Update ".$count." record.";
                        }
                }else if ($kpi_accept == 2 and $kpi_comment != null  ) {

                    $sqlOldScore = "SELECT `kpi_score_raw`, `kpi_score` FROM $kpiScoreTable WHERE `kpi_score_id` = :kpi_score_id";
                    $stmOldScore = $kpi->conn->prepare($sqlOldScore);
                    $stmOldScore->bindParam(":kpi_score_id",$_POST['kpi_score_id']);
                    $stmOldScore->execute();
                    $RstmOldScore = $stmOldScore->fetchAll();
                    
                    // echo "<pre>";
                    // print_r($RstmOldScore[0]['kpi_score_raw']);
                    // echo "</pre>";

                    $sqlComment = "INSERT INTO $kpiComment (`kpi_score_id`,`kpi_score_raw`,`kpi_score`,`kpi_comment`,`who_is_accept`, `date_time`) 
                    VALUES (:kpi_score_id ,:kpi_score_raw,:kpi_score, :kpi_comment , :who_is_accept ,CURRENT_TIMESTAMP)";
                    // echo $sqlComment    ;
                    $stm2 = $kpi->conn->prepare($sqlComment);
                    $stm2->bindParam(":kpi_score_id",$_POST['kpi_score_id']);
                    $stm2->bindParam(":kpi_score_raw",$RstmOldScore[0]['kpi_score_raw']);
                    $stm2->bindParam(":kpi_score",$RstmOldScore[0]['kpi_score']);
                    $stm2->bindParam(":kpi_comment",$kpi_comment);
                    $stm2->bindParam(":who_is_accept",$who_is_accept);
                    $stm2->execute();

                    $sql = "UPDATE $kpiScoreTable SET `kpi_accept` = :kpi_accept,
                                                        `kpi_score` = :kpi_score,
                                                        `kpi_score_raw` = :kpi_score_raw,
                                                        `who_is_accept` = :who_is_accept,
                                                        `date_who_id_accept` = :date_who_id_accept 
                                                        WHERE `$kpiScoreTable`.`kpi_score_id` = :kpi_score_id ";
                                                        
                        $stm = $kpi->conn->prepare($sql);
                        $stm->bindValue(":kpi_accept",null);
                        $stm->bindValue(":kpi_score",null);
                        $stm->bindValue(":kpi_score_raw",null);
                        $stm->bindParam(":who_is_accept",$who_is_accept);
                        $stm->bindParam(":date_who_id_accept",$date_who_id_accept);
                        $stm->bindParam(":kpi_score_id",$_POST['kpi_score_id']);
                        $stm->execute();
                        $count = $stm->rowCount();

                        if ($count == 0) {
                            $success['success'] = false;
                            $success['msg'] = "Data not update.";
                        }else {
                            $success['success'] = true;
                            $success['msg'] = "Update ".$count." record.";
                        }

                }else if($kpi_comment === null){
                    $success['success'] = false;
                    $success['msg'] = "คุณไม่ได้อธิบายเหตุผล";
                }else{
                    $success['success'] = false;
                    $success['msg'] = "";
                }
                    
               
                

            }catch(Exception $e)
            {
                $err = $e->getMessage();
                $success['success'] = null;
                $success['msg'] = $err;
            }
        }elseif ($checkAccept['success']== true) {
            $success['success'] = false;
            $success['msg'] = "ข้อมูลถูกบันทึกไปก่อนหน้านี้แล้ว  ไม่สามารถบันทึกซ้ำได้.";
        }
    
}else {
    $success['success'] = null;
    $success['msg'] = "POST variable not found.";
}

echo json_encode($success);