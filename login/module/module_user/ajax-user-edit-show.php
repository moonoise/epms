<?php
session_start();
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";


$db = new DbConn;
$success = array();
try {
   $sql = "SELECT $db->tbl_members.id ,
                    $db->tbl_members.username ,
                    $db->tbl_members.fname ,
                    $db->tbl_members.lname ,
                    $db->tbl_members.email ,
                    $db->tbl_members.phone ,
                    $db->tbl_members.phone_org ,
            $db->tbl_groupUsers.group_id,
            $db->tbl_groupUsers.org_id AS group_org_id,
            $db->tbl_groupUsers.org_id_1 AS group_org_id_1,
            $db->tbl_groupUsers.org_id_2 AS group_org_id_2,
            (SELECT org_name FROM per_org WHERE per_org.org_id = $db->tbl_groupUsers.org_id) as org_name,
            (SELECT org_name FROM per_org WHERE per_org.org_id = $db->tbl_groupUsers.org_id_1) as org_name_1,
            (SELECT org_name FROM per_org WHERE per_org.org_id = $db->tbl_groupUsers.org_id_2) as org_name_2,
            (SELECT t2.username FROM $db->tbl_members t2 WHERE t2.id = $db->tbl_members.id) as head_username,
            (SELECT t2.fname FROM $db->tbl_members t2 WHERE t2.id = $db->tbl_members.id) as head_fname,
            (SELECT t2.lname FROM $db->tbl_members t2 WHERE t2.id = $db->tbl_members.id) as head_lname
            FROM $db->tbl_members  
            LEFT JOIN $db->tbl_groupUsers ON $db->tbl_members.id = $db->tbl_groupUsers.id
            WHERE $db->tbl_members.id = :id
              " ; 
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(":id",$_POST["id_admin"]);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    $success['success'] = true;
    $success['result'] = $result;
    $success['msg'] = null;

} catch (\Exception $e) {
    $success['success'] = null;
    $success['result'] = null;
    $success['msg'] = $e;
}

echo json_encode($success);

