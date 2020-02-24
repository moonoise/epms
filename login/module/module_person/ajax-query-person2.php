<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
include_once "class-person.php";
include_once "../report/class-report.php";
$db = new DbConn;
$person = new person;
// foreach ($_POST as $key => $value) {
//    echo $key ."->". $value;
// }
if (isset($_POST['org_id_2']) and $_POST['org_id_2'] != "") {
    $orgSelect = $_POST['org_id_2'];
}elseif (isset($_POST['org_id_1']) and $_POST['org_id_1'] != "") {
    $orgSelect = $_POST['org_id_1'];
}elseif (isset($_POST['org_id']) and $_POST['org_id'] != "") {
    $orgSelect = $_POST['org_id'];
}


    $sql = "select * ,per_level.position_level from ".$tbl_per_personal." 
            LEFT JOIN per_level ON per_level.level_no = ".$tbl_per_personal.".level_no
            where org_id = :org_id OR org_id_1 = :org_id OR org_id_2 = :org_id ";
    // $sql = "select * from ".$tbl_per_personal." 
    // where org_id = :org_id OR org_id_1 = :org_id OR org_id_2 = :org_id ";
    $stm = $db->conn->prepare($sql);
    $stm->bindParam(':org_id',$orgSelect);
    $stm->bindParam(':org_id_1',$orgSelect);
    $stm->bindParam(':org_id_2',$orgSelect);
    $stm->execute();
    $result = $stm->fetchAll();

    if(count($result) > 0){
        $data =  $person->dataTable($result,$_SESSION[__EVALUATION_ON_OFF__]);
        $data['success'] = true;
    }else {
        $data['success'] = false;
    }
    
    echo json_encode($data);

?>
