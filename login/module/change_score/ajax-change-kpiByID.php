<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../myClass.php";

$success = array(
    'success' => null,
    'result' => null,
    'msg' => null
);

try {
    $db = new DbConn;
    $myClass = new myClass;
    $tableYears = $myClass->callYear();

    $sql = "UPDATE " . $tableYears['data']['kpi_score'] . " SET weight = :w WHERE kpi_score_id = :kpi_score_id ";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(":w", $_POST['weight']);
    $stm->bindParam(":kpi_score_id", $_POST['kpi_score_id']);
    $stm->execute();

    $success['success'] = true;
} catch (\Exception $e) {
    $success['success'] = false;
    $success['msg'] = $e;
}


echo json_encode($success);
