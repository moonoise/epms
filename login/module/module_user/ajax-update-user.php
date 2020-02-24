<?php
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";
    
    $db = new DbConn;
    $success =  array('success' => true ,
                        'msg' => null ,
                    'codeError' => null  );

    if (isset($_POST['org_id_edit'])) {
        if ($_POST['org_id_edit'] !="") {
            $org_id = $_POST['org_id_edit']; 
        }else {
            $org_id = NULL;
        }
    }else {
        $org_id = NULL; 
    }

    if (isset($_POST['org_id_1_edit'])) {
        if ($_POST['org_id_1_edit'] !="") {
            $org_id_1 = $_POST['org_id_1_edit']; 
        }else {
            $org_id_1 = NULL;
        }
    }else {
        $org_id_1 = NULL; 
    }

    if (isset($_POST['org_id_2_edit'])) {
        if ($_POST['org_id_2_edit'] !="") {
            $org_id_2 = $_POST['org_id_2_edit']; 
        }else {
            $org_id_2 = NULL;
        }
    }else {
        $org_id_2 = NULL; 
    }

    try {
        $tbl_member = $db->tbl_members;
        $tbl_groupUser = $db->tbl_groupUsers;
        if ($org_id != null || $org_id_1 != null || $org_id_2 != null) {
           
            $sql = "UPDATE $tbl_member , $tbl_groupUser SET 
                                        $tbl_member.`fname` = :fname ,
                                        $tbl_member.`lname` = :lname ,
                                        $tbl_member.`email` = :email ,
                                        $tbl_member.`phone` = :phone ,
                                        $tbl_member.`phone_org` = :phone_org ,
                                        $tbl_member.`org_id` = :org_id ,
                                        $tbl_member.`org_id_1` = :org_id_1 ,
                                        $tbl_member.`org_id_2` = :org_id_2,
                                        $tbl_groupUser.`org_id` = :org_id ,
                                        $tbl_groupUser.`org_id_1` = :org_id_1 ,
                                        $tbl_groupUser.`org_id_2` = :org_id_2,
                                        $tbl_groupUser.`group_id` = :group_id  
                                        WHERE $tbl_member.`id` = :id  
                                            AND $tbl_groupUser.`id` = :id ";


            $stm = $db->conn->prepare($sql);
            $stm->bindParam(":fname",$_POST['first_name_edit']);
            $stm->bindParam(":lname",$_POST['last_name_edit']);
            $stm->bindParam(":email",$_POST['email_edit']);
            $stm->bindParam(":phone",$_POST['phone_edit']);
            $stm->bindParam(":phone_org",$_POST['phone_org_edit']);
            $stm->bindParam(":org_id",$org_id);
            $stm->bindParam(":org_id_1",$org_id_1);
            $stm->bindParam(":org_id_2",$org_id_2); 
            $stm->bindParam(":group_id",$_POST['user_group_edit']);
            $stm->bindParam(":id",$_POST['id']);
            $stm->execute();

        }else {
            $sql = "UPDATE $tbl_member , $tbl_groupUser  SET 
                                        $tbl_member.`fname` = :fname ,
                                        $tbl_member.`lname` = :lname ,
                                        $tbl_member.`email` = :email ,
                                        $tbl_member.`phone` = :phone ,
                                        $tbl_member.`phone_org` = :phone_org,
                                        $tbl_groupUser.`group_id` = :group_id
                                        WHERE $tbl_member.`id` = :id
                                        AND $tbl_groupUser.`id` = :id ";
            $stm = $db->conn->prepare($sql);
            $stm->bindParam(":fname",$_POST['first_name_edit']);
            $stm->bindParam(":lname",$_POST['last_name_edit']);
            $stm->bindParam(":email",$_POST['email_edit']);
            $stm->bindParam(":phone",$_POST['phone_edit']);
            $stm->bindParam(":phone_org",$_POST['phone_org_edit']);
            $stm->bindParam(":group_id",$_POST['user_group_edit']);
            $stm->bindParam(":id",$_POST['id']);
            $stm->execute();
        }
    } catch (\Exception $e) {
        $success['success'] = null;
        $success['codeError'] = $e->getCode();
        $success['msg'] = $e->getMessage();
    }

    echo json_encode($success);
