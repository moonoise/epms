<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../../includes/class.password-hash.php";

    $err = '';
    $success = array("success"=> null,
                    "message" => null ,
                    "error_code" => null ,
                    "data" => null );
    $db = new DbConn;
    $password_hash = new Password_Hash;
    try {
        $newPasswordHash = $password_hash->create_password_hash($_POST['new_password']);
        
        $stmBegin = $db->conn->prepare("BEGIN");
        $stmBegin->execute();

        $sql= "UPDATE  $db->tbl_members SET `password` = :p WHERE id = :id";
        $stm= $db->conn->prepare($sql);
        $stm->bindParam(":p",$newPasswordHash);
        $stm->bindParam(":id",$_POST['id_user_change_password']);
        $stm->execute();

        if ($stm->rowCount() == 1 ) {
            $success['success'] = true;
            $success['message'] = "New Password saved.";
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