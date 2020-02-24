<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";


    $err = '';
    $success = array("success"=> null,
                    "message" => null ,
                    "error_code" => null ,
                    "data" => null );
    $db = new DbConn;
    try {
    
        
        $stmBegin = $db->conn->prepare("BEGIN");
        $stmBegin->execute();

        $sql= "UPDATE  $db->tbl_members SET `status_user` =  ( case when (status_user = 1) then 0 else 1 end  ) WHERE id = :id ";
        $stm= $db->conn->prepare($sql);
        $stm->bindParam(":id",$_POST['id_user_change_status']);
        $stm->execute();

        if ($stm->rowCount() == 1 ) {
            $success['success'] = true;
            $success['message'] = "stutus user changed.";
            $success['data'] = $stm->rowCount();
            $stmCommit = $db->conn->prepare("COMMIT");
            $stmCommit->execute();
        }else if ( $stm->rowCount() > 1 ) {
            $success['success'] = false;
            $success['message'] = "update more 1 record.";
            $stmCommit = $db->conn->prepare("ROLLBACK");
            $stmCommit->execute();
        }elseif ($stm->rowCount() == 0 ) {
            $success['success'] = false;
            $success['message'] = "update 0 record.";
        }
    } catch (\Exception $e) {
        $success['success'] = null;
        $success['message'] = $e->getMessage();
        $success['error_code'] = $e->getCode();

    }

echo json_encode($success);