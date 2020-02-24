<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
$success = array('success' => null,
                'result' => null,
                'msg' => null );
try {
    $db = new DbConn;

    $sql = "SELECT * FROM `table_year` WHERE use_status = 1  ORDER BY `table_year`.`table_year` ASC ";
    $stm = $db->conn->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    $success['success'] = true;
    $success['result'] = $result;
    
} catch (Exception $e) {
    $success['success'] = null;
    $success['msg'] = $e;
}
echo json_encode($success);