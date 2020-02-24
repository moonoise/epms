<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";

    $err = '';
    $success = array();

    try {
        $db = new DbConn;
        $sql= "UPDATE  $db->tbl_members SET status_user = 0 WHERE id = :id";
        $stm= $db->conn->prepare($sql);
        $stm->bindParam(":id",$_POST['id']);
        $stm->execute();
        if (count($stm->rowCount()) > 0 ) {
            $success['success'] = true;
        }
    } catch (\Exception $e) {
        $success['success'] = null;
        $success['msg'] = $e;

    }

echo json_encode($success);

