<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-person.php";
include_once "../report/class-report.php";
include_once "../myClass.php";

$db = new DbConn;
$person = new person;
$myClass = new myClass;
$currentYear = $myClass->callYear();
// foreach ($_POST as $key => $value) {
//    echo $key ."->". $value;
// }

if ($_POST['per_name'] != "" and $_POST['org_id'] != "") {
    $orgSelect = $_POST['org_id'];
    $s = ($orgSelect == 77 ? "" : " AND (org_id = $orgSelect OR org_id_1 = $orgSelect OR org_id_2 = $orgSelect)");

    $sql = "SELECT  *,per_level.position_level FROM " . $currentYear['data']['per_personal'] . " 
    LEFT JOIN per_level ON per_level.level_no = " . $currentYear['data']['per_personal'] . ".level_no WHERE " . $currentYear['data']['per_personal'] . ".per_type = '1' AND   (`per_name` LIKE CONCAT('%',SUBSTRING_INDEX(:per_name,' ',1),'%') 
            OR `per_surname` LIKE CONCAT('%',SUBSTRING_INDEX(:per_name,' ',-1),'%') ) " . $s;

    $stm = $db->conn->prepare($sql);
    $stm->bindParam(':per_name', $_POST['per_name']);
    $stm->execute();
    $result = $stm->fetchAll();
    if (count($result) > 0) {
        $data =  $person->dataTableHead($result, $_SESSION[__EVALUATION_ON_OFF__]);
        $data['success'] = true;
    } else {
        $data['success'] = false;
    }
} else {
    $data['success'] = false;
}

echo json_encode($data);
