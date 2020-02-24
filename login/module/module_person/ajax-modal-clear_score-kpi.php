<?php 
include_once "../../config.php";
include_once "../../includes/dbconn.php";

$db = new DbConn;
$success = array();

if(!empty($_POST['kpi_score_id'])){
    $text = array_filter($_POST['kpi_score_id']);
    $sqlIN = implode(",",$text);
   
    if ($_POST['typeClear'] == 1) {
        $sql = "UPDATE ".$db->tbl_kpi_score." SET 
                kpi_score = null,
                kpi_score_raw = null,
                kpi_accept = null
                WHERE  kpi_score_id IN ($sqlIN) ";

        $sql2 = "DELETE FROM ".$db->tbl_kpi_comment." WHERE kpi_score_id IN ($sqlIN) ";

    }elseif ($_POST['typeClear'] == 2) {
        $sql = "UPDATE ".$db->tbl_kpi_score." SET 
                kpi_accept = null
                WHERE  kpi_score_id IN ($sqlIN) ";

        $sql2 = "DELETE FROM ".$db->tbl_kpi_comment." WHERE kpi_score_id IN ($sqlIN) ";
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