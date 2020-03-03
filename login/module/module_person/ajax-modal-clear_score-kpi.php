<?php 
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../myClass.php";

$db = new DbConn;
$success = array();
$myClass = new myClass;
$currentYear = $myClass->callYear();

$kpiScoreTable = $currentYear['data']['kpi_score'];
$kpiComment = $currentYear['data']['kpi_comment'];
$per_personalTable = $currentYear['data']['per_personal'];

if(!empty($_POST['kpi_score_id'])){
    $text = array_filter($_POST['kpi_score_id']);
    $sqlIN = implode(",",$text);
   
    if ($_POST['typeClear'] == 1) {
        $sql = "UPDATE $kpiScoreTable SET 
                kpi_score = null,
                kpi_score_raw = null,
                kpi_accept = null
                WHERE  kpi_score_id IN ($sqlIN) ";

        $sql2 = "DELETE FROM $kpiComment WHERE kpi_score_id IN ($sqlIN) ";

    }elseif ($_POST['typeClear'] == 2) {
        $sql = "UPDATE $kpiScoreTable SET 
                kpi_accept = null
                WHERE  kpi_score_id IN ($sqlIN) ";

        $sql2 = "DELETE FROM $kpiComment WHERE kpi_score_id IN ($sqlIN) ";
    }
    
    $stm = $db->conn->prepare($sql);
    $stm->execute();

    $stm2 = $db->conn->prepare($sql2);
    $stm2->execute();
    
    // if ( $stm->rowCount() > 0) {
    //     $success['success'] = true;
    // }else {
    //     $success['success'] = false;
    // }
    $success['success'] = true;
}else {
    $success['success'] = false;
}


echo json_encode($success);

?>