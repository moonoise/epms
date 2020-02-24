<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";

    $err = "";
    $success = array();
    $success['msg'] = "";
    try{
    $db = new DbConn;

    $sql = "SELECT  `per_cardno` ,
                     `pn_name`, 
                    `per_name`,
                    `per_surname`,
                    `pl_name`,
                    `org_name`,
                    `org_name1`,
                    `org_name2`
                     FROM ".$db->tbl_per_personal." 
                     WHERE `per_name` = :fname AND `per_surname` like :lname AND per_cardno <> :per_cardno_user ";
    $stm = $db->conn->prepare($sql);
    $lname = "%".$_POST['lname']."%";
    $stm->bindParam(":fname", $_POST['fname']);
    $stm->bindParam(":lname", $lname);
    $stm->bindParam(":per_cardno_user", $_POST['per_cardno_user']);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    if(count($result) > 0){
        $success['success'] = true;
    }else {
        $success['success'] = false;
    }

    }catch(Exception $e){
        $success['success'] = null;
        $success['msg'] = $e->getMessage();
    }
// echo $sql;
foreach ( $result as $key => $value) {
    $success['text'][$key] = " <tr>
                                    <th scope='row'>#</th>
                                    <td>".$value['pn_name'].$value['per_name']." ".$value['per_surname']."</td>".
                                    "<td><button type='button' class='btn btn-info' onclick='select_head(`".$value['per_cardno']."`)'>เลือก</button></td>
                                </tr>";
                                
}
    echo json_encode($success);
