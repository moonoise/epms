<?php
session_start();
    include_once "../../config.php";
    include_once "../../includes/dbconn.php";


$db = new DbConn;

if((isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(4,5))) ){ 
    $query = "SELECT
                members.id,
                members.username,
                members.fname,
                members.lname,
                members.email,
                members.phone,
                members.phone_org,
                members.status_user,
                group_users.id as g_id,
                group_users.group_id ,
                (SELECT t1.group_name FROM member_groups t1 WHERE t1.group_id = group_users.group_id ) as group_name ,
                (SELECT t2.org_name FROM per_org t2 WHERE t2.org_id = group_users.org_id ) as org_name,
                (SELECT t2.org_name FROM per_org t2 WHERE t2.org_id = group_users.org_id_1 ) as org_name_1,
                (SELECT t2.org_name FROM per_org t2 WHERE t2.org_id = group_users.org_id_2 ) as org_name_2
                FROM
                members
                LEFT JOIN group_users on group_users.id = members.id WHERE `members`.`status_user` = 1 ";
                
                //  WHERE `members`.`soft_delete` = 1
// member_groups.group_name,
// per_org.org_name,
// per_org1.org_name as org_name_1,
// per_org2.org_name as org_name_2
// LEFT JOIN member_groups on group_users.group_id = member_groups.group_id
// LEFT JOIN per_org ON per_org.org_id = members.org_id
// LEFT JOIN per_org per_org1 ON  members.org_id_1 = per_org1.org_id
// LEFT JOIN per_org per_org2 ON  members.org_id_2 = per_org2.org_id
                $stmt = $db->conn->prepare($query);
                
                $stmt->execute();
                $c = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else if((isset($_SESSION[__USER_ID__]) and in_array($_SESSION[__GROUP_ID__],array(6,7))) ){
    $query = "SELECT
                members.id,
                members.username,
                members.fname,
                members.lname,
                members.email,
                members.phone,
                members.phone_org,
                members.status_user,
                group_users.id as group_id,
                member_groups.group_name,
                per_org.org_name,
                per_org1.org_name as org_name_1,
                per_org2.org_name as org_name_2
                FROM
                members
                LEFT JOIN group_users on group_users.id = members.id
                LEFT JOIN member_groups on group_users.group_id = member_groups.group_id
                LEFT JOIN per_org ON per_org.org_id = group_users.org_id
                LEFT JOIN per_org per_org1 ON  group_users.org_id_1 = per_org1.org_id
                LEFT JOIN per_org per_org2 ON  group_users.org_id_2 = per_org2.org_id
                WHERE members.id = :id  and  `members`.`status_user` = 1
                ";
// AND `members`.`status_user` = 1 
                $stmt = $db->conn->prepare($query);
                $stmt->bindParam(":id",$_SESSION[__USER_ID__]);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $a =array();
                $b =array();
                $c =array();

                $query2 = "SELECT   members.id,
                                    members.username,
                                    members.fname,
                                    members.lname,
                                    members.email,
                                    members.phone,
                                    members.phone_org,
                                    members.status_user,
                                    group_users.id as g_id,
                                    group_users.group_id ,
                                    member_groups.group_name,
                                    per_org.org_name,
                                    per_org1.org_name as org_name_1,
                                    per_org2.org_name as org_name_2
                            FROM group_users 
                            LEFT JOIN member_groups on group_users.group_id = member_groups.group_id
                            LEFT JOIN members ON group_users.id = members.id
                            LEFT JOIN per_org ON per_org.org_id = group_users.org_id
                            LEFT JOIN per_org per_org1 ON  group_users.org_id_1 = per_org1.org_id
                            LEFT JOIN per_org per_org2 ON  group_users.org_id_2 = per_org2.org_id
                            WHERE group_users.head_admin = :id  and  `members`.`status_user` = 1";
                            //  AND `members`.`status_user` = 1
                $stmt2 = $db->conn->prepare($query2);
                $stmt2->bindParam(":id",$_SESSION[__USER_ID__]);
                $stmt2->execute();
                $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                $c = array_merge($result,$result2);
}


// echo "<pre>";
// print_r($c);
// echo "</pre>";

$a['col_3']="";
// $output = array('user'=>array() );
foreach ($c as $row) {
    
    $a['col_1'] = "<span class='text text-info'>".$row['username']."</span>";
    $a['col_2'] = $row['fname'] ." ".$row['lname'];
    
    if (!empty($row['org_name']) ||  !empty($row['org_name_1']) || !empty($row['org_name_2']) ) {
        $a['col_3'] = "<ul>";
            if (!empty($row['org_name']))  {
                $a['col_3'] .= "<li><i class='fa fa-chevron-circle-right'></i> ".$row['org_name']." </li>";
            }
            if (!empty($row['org_name_1']))  {
                $a['col_3'] .= "<ul>";
                $a['col_3'] .= "<li><i class='fa fa-chevron-circle-right'></i> ".$row['org_name_1']." </li>";
                
                if (!empty($row['org_name_2']))  {
                    $a['col_3'] .= "<ul> 
                                        <li><i class='fa fa-chevron-circle-right'></i> ".$row['org_name_2']." </li>
                                    </ul>";
                }
                
                $a['col_3'] .= "</ul>";
            }

        $a['col_3'] .= "</ul>";

    
    }else {
        $a['col_3'] = " ไม่ได้ระบุ ";
    }
    if ($_SESSION[__GROUP_ID__] != 7  ) {
        $editDisabled  = "";
        if($_SESSION[__GROUP_ID__] == 4 || $_SESSION[__GROUP_ID__] == 5 ){
            if ($row['group_id'] == 7 ) {
                $editDisabled = "disabled";
            }else {
                $editDisabled = "";
            }
        }
        $a['col_4'] = '<button type="button" data-toggle="tooltip" data-placement="top"  data-original-title="แก้ไขข้อมูล ADMIN" onclick="user_edit(`'.$row['id'].'`)" class="btn btn-warning confirm-edit"  '.$editDisabled .'><i class="fa fa-edit"></i></button> 
                        <button type="button" data-toggle="tooltip" data-placement="top"  data-original-title="เปลี่ยน Password" onclick="change_password(`'.$row['id'].'`)" class="btn btn-danger " ><i class="fa fa-key"></i></button>     
                        
                    ';
                    // <button type="button"  data-toggle="tooltip" data-placement="top"  data-original-title="ปิด/เปิด การใช้งาน" onclick="status_user(`'.$row['id'].'`)" class="btn '.($row['status_user']==1?"btn-info":"btn-danger").' confirm-del" disabled><i class="fa '.($row['status_user']===1?"fa-unlock":"fa-lock").'"></i></button>  
                        // <button type="button" data-toggle="tooltip" data-placement="top"  data-original-title="ลบผู้ใช้งาน" onclick="user_delete(`'.$row['id'].'`)" class="btn btn-danger confirm-delete" disabled><i class="fa  fa-eraser"></i></button>              

    }else {
        $a['col_4'] = "";
    }
    
    $b[] = $a;
    unset($a);
  
}



$data = array('data' => $b );
// echo "<pre>";
// print_r($data);
// echo "</pre>";
echo json_encode($data);

