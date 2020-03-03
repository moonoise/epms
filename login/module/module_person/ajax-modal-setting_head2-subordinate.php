<?php
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "../myClass.php";

$db = new DbConn;
$myClass = new myClass;
$currentYear = $myClass->callYear();
// foreach ($_POST as $key => $value) {
//     echo $key."->".$value;
// }
if(isset($_POST['org_id_2-head2']) and $_POST['org_id_2-head2'] != ""){

    $sql = "select * from ".$currentYear['data']['per_personal']." where org_id_2 = :org_id_2  AND  per_cardno != :head  ";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(':org_id_2',$_POST['org_id_2-head2']);
    $stm->bindParam(':head',$_POST['modal-per_cardno-settingHead-input-2']);
    $stm->execute();
    $result = $stm->fetchAll();
    
    dataTable($result);
    
}elseif (isset($_POST['org_id_1-head2']) and $_POST['org_id_1-head2'] != "") {

    $sql = "select * from ".$currentYear['data']['per_personal']." where org_id_1 = :org_id_1  AND  per_cardno != :head";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(':org_id_1',$_POST['org_id_1-head2']);
    $stm->bindParam(':head',$_POST['modal-per_cardno-settingHead-input-2']);
    $stm->execute();
    $result = $stm->fetchAll();
    
    dataTable($result);
  
}elseif (isset($_POST['org_id-head2']) and $_POST['org_id-head2'] != "") {
    $sql = "select * from ".$currentYear['data']['per_personal']." where org_id = :org_id   AND  per_cardno != :head";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(':org_id',$_POST['org_id-head2']);
    $stm->bindParam(':head',$_POST['modal-per_cardno-settingHead-input-2']);
    $stm->execute();
    $result = $stm->fetchAll();
    
    dataTable($result);
    // echo $_POST['modal-per_cardno-settingHead-input'];
}

function dataTable($result) {
    $r = array();
    $d = array();
    foreach ($result as $key => $value) {
      
    $d[] = array($value['per_cardno'],
                 $value['pn_name'].$value['per_name']." ". $value['per_surname'],
                 $value['pm_name'],
                 "<button type='button' class='btn btn-info btn-xs confirm-change-head-2' 
                                onclick='changeHead2(`".$value['per_cardno']."`)' data-original-title='' title=''>
                                  <i class ='fa fa-plus'></i></button>
                                  <script>
                                  $('.confirm-change-head-2').popConfirm({
                                          title: 'เปลี่ยนผู้บังคับบัญชา', // The title of the confirm
                                          content: 'คุณต้องการเปลี่ยนผู้บังคับบัญชา จริงๆ หรือใหม่ ?', // The message of the confirm
                                          placement: 'right', // The placement of the confirm (Top, Right, Bottom, Left)
                                          container: 'body', // The html container
                                          yesBtn: 'ใช่',
                                          noBtn: 'ไม่'
                                          });
                                  </script>
                                  "
                     );
  
    }

//     echo "<pre>";
//     print_r($r);
//  echo "</pre>";

   $data = array('data' => $d );
    echo json_encode($data);
}

// $t ='';
  
// foreach ($result as $key => $row) {
//    $t .= "<tr>";
//    $t .= "<td>".$row['per_cardno']."</td>";
//    $t .= "<td>".$row['per_name']." ".$row['per_surname']."</td>";
//    $t .= "<td>".$row['pm_name']."</td>";
//    $t .= "<td><button type='button' class='btn btn-info btn-xs' 
//                 onclick='' data-original-title='' title=''>
//                 <i class ='fa fa-plus'></i></button></td>";
//    $t .= "</tr>";        
          
// }

// echo $t;