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
                members.tel,
                members.picture_profile,
                group_users.id as group_id,
                member_groups.group_name,
                per_org.org_name,
                per_org1.org_name as org_name_1,
                per_org2.org_name as org_name_2
                FROM
                members
                LEFT JOIN group_users on group_users.id = members.id
                LEFT JOIN member_groups on group_users.group_id = member_groups.group_id
                LEFT JOIN per_org ON per_org.org_id = members.org_id
                LEFT JOIN per_org per_org1 ON  members.org_id_1 = per_org1.org_id
                LEFT JOIN per_org per_org2 ON  members.org_id_2 = per_org2.org_id
                WHERE `members`.`status_user` = 1 
                ";

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
                members.tel,
                members.picture_profile,
                group_users.id as group_id,
                member_groups.group_name,
                per_org.org_name,
                per_org1.org_name as org_name_1,
                per_org2.org_name as org_name_2
                FROM
                members
                LEFT JOIN group_users on group_users.id = members.id
                LEFT JOIN member_groups on group_users.group_id = member_groups.group_id
                LEFT JOIN per_org ON per_org.org_id = members.org_id
                LEFT JOIN per_org per_org1 ON  members.org_id_1 = per_org1.org_id
                LEFT JOIN per_org per_org2 ON  members.org_id_2 = per_org2.org_id
                WHERE members.id = :id  AND `members`.`status_user` = 1 
                ";

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
                                    members.tel,
                                    members.picture_profile,
                                    group_users.id as group_id,
                                    member_groups.group_name,
                                    per_org.org_name,
                                    per_org1.org_name as org_name_1,
                                    per_org2.org_name as org_name_2
                            FROM group_users 
                            LEFT JOIN member_groups on group_users.group_id = member_groups.group_id
                            LEFT JOIN members ON group_users.id = members.id
                            LEFT JOIN per_org ON per_org.org_id = members.org_id
                            LEFT JOIN per_org per_org1 ON  members.org_id_1 = per_org1.org_id
                            LEFT JOIN per_org per_org2 ON  members.org_id_2 = per_org2.org_id
                            WHERE group_users.head_admin = :id  AND `members`.`status_user` = 1 ";
                            
                $stmt2 = $db->conn->prepare($query2);
                $stmt2->bindParam(":id",$_SESSION[__USER_ID__]);
                $stmt2->execute();
                $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                $c = array_merge($result,$result2);
}


// echo "<pre>";
// print_r($c);
// echo "</pre>";


// $output = array('user'=>array() );
foreach ($c as $row) {
    
    $a['col_1'] = $row['username']."<br>". $row['email']."<br>". $row['tel'];
    $a['col_2'] = $row['fname'] ." ".$row['lname'];
    $a['col_3'] = $row['group_name'];
    $a['col_4'] = $row['org_name'] ."<br>".$row['org_name_1']."<br>".$row['org_name_2'];
    if(!empty($row['picture_profile'])){
        $a['col_5'] = "<img src='../external/images_profile/".$row['picture_profile']."'height='42' width='42'>";
    }else {
        $a['col_5'] = "";
    }
    if ($_SESSION[__GROUP_ID__] != 7  ) {
        $a['col_6'] = '<button type="button" onclick="user_edit(`'.$row['id'].'`)" class="btn btn-warning confirm-edit"><i class="fa fa-edit"></i></button> <button type="button" onclick="user_del(`'.$row['id'].'`)" class="btn btn-danger confirm-del"><i class="fa fa-eraser"></i></button>
                        <script>    
                            $(".confirm-del").popConfirm({
                                    title: "ลบรายชื่อ", // The title of the confirm
                                    content: "คุณต้องการลบรายชื่อนี้ จริงๆ หรือใหม่ ?", // The message of the confirm
                                    placement: "left", // The placement of the confirm (Top, Right, Bottom, Left)
                                    container: "body", // The html container
                                    yesBtn: "ใช่",
                                    noBtn: "ไม่"
                            });
                        </script>
                    ';
    }else {
        $a['col_6'] = "";
    }
    
    $b[] = $a;
    unset($a);
  
}



$data = array('data' => $b );
// echo "<pre>";
// print_r($data);
// echo "</pre>";
echo json_encode($data);

