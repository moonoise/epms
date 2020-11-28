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
if (isset($_POST['org_id_2-head']) and $_POST['org_id_2-head'] != "") {

    $sql = "select * from " . $currentYear['data']['per_personal'] . " where org_id_2 = :org_id_2 and (head != :head or head IS NULL ) AND  per_cardno != :head AND per_type = 3 ";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(':org_id_2', $_POST['org_id_2-head']);
    $stm->bindParam(':head', $_POST['modal-per_cardno-settingHead-input']);
    $stm->execute();
    $result = $stm->fetchAll();

    dataTable($result);
} elseif (isset($_POST['org_id_1-head']) and $_POST['org_id_1-head'] != "") {

    $sql = "select * from " . $currentYear['data']['per_personal'] . " where org_id_1 = :org_id_1 and (head != :head or head IS NULL) AND  per_cardno != :head AND per_type = 3";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(':org_id_1', $_POST['org_id_1-head']);
    $stm->bindParam(':head', $_POST['modal-per_cardno-settingHead-input']);
    $stm->execute();
    $result = $stm->fetchAll();

    dataTable($result);
} elseif (isset($_POST['org_id-head']) and $_POST['org_id-head'] != "") {
    $sql = "select * from " . $currentYear['data']['per_personal'] . " where org_id = :org_id and (head != :head or head IS NULL ) AND  per_cardno != :head AND per_type = 3";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(':org_id', $_POST['org_id-head']);
    $stm->bindParam(':head', $_POST['modal-per_cardno-settingHead-input']);
    $stm->execute();
    $result = $stm->fetchAll();

    dataTable($result);
    // echo $_POST['modal-per_cardno-settingHead-input'];
}

function dataTable($result)
{
    $r = array();
    $d = array();
    foreach ($result as $key => $value) {

        $d[] = array(
            "<div class='checkbox checkbox-warning'>
                    <input id='checkbox-" . $value['per_cardno'] . "' type='checkbox' class='headSelectCheckbox' onclick='subordinateList(`" . $value['per_cardno'] . "`,`checkbox-" . $value['per_cardno'] . "`)'>
                    <label for='checkbox-" . $value['per_cardno'] . "'></label>
                </div>",
            $value['per_cardno'],
            $value['pn_name'] . $value['per_name'] . " " . $value['per_surname'],
            $value['pm_name'],
            "<button type='button' class='btn btn-info btn-xs confirm-change-head' 
                                onclick='changeHead(`" . $value['per_cardno'] . "`)' data-original-title='' title=''>
                                  <i class ='fa fa-plus'></i></button>
                                  <script>
                                  $('.confirm-change-head').popConfirm({
                                          title: 'เพิ่มรายชื่อ', // The title of the confirm
                                          content: 'คุณต้องการเพื่มรายชื่อนี้ จริงๆ หรือใหม่ ?', // The message of the confirm
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

    $data = array('data' => $d);
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