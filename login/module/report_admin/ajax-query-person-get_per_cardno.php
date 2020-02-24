<?php
session_start();
include_once "../../config.php";
include_once "../../includes/dbconn.php";
$db = new DbConn;

$years = $_POST['years'];
if (isset($_POST['org_id_2']) and $_POST['org_id_2'] != "") {
    $orgSelect = $_POST['org_id_2'];
}elseif (isset($_POST['org_id_1']) and $_POST['org_id_1'] != "") {
    $orgSelect = $_POST['org_id_1'];
}elseif (isset($_POST['org_id']) and $_POST['org_id'] != "") {
   
        $orgSelect = $_POST['org_id'];
    
    
}
$errYears = "";
$errPer_cardno = "";

$per_cardnoResult = array("success" => "",
                    "result" => "",
                    "table_year" => "",
                    "msg" => "");

try {
    $sql_years = "SELECT * FROM `table_year` WHERE `table_year`.`table_year` = :years ";
    $stmYears = $db->conn->prepare($sql_years);
    $stmYears->bindParam(':years',$years);
    $stmYears->execute();
    $resultYears = $stmYears->fetchAll(PDO::FETCH_ASSOC);
    
} catch (\Exception $e) {
    $errYears = $e->getMessage();
}


try {
    if ($orgSelect == "77") {
        $sql = "select per_cardno from ".$resultYears[0]['per_personal'];
        $stm = $db->conn->prepare($sql);
        $stm->execute();
    }else {
        $sql = "select per_cardno from ".$resultYears[0]['per_personal']." where org_id = :org_id OR org_id_1 = :org_id OR org_id_2 = :org_id ";
        $stm = $db->conn->prepare($sql);
        $stm->bindParam(':org_id',$orgSelect);
        $stm->bindParam(':org_id_1',$orgSelect);
        $stm->bindParam(':org_id_2',$orgSelect);
        $stm->execute();
    }
    
    $result = $stm->fetchAll(PDO::FETCH_COLUMN);


} catch (\Exception $e) {
    $errPer_cardno = $e->getMessage();
}

if ($errPer_cardno == "" && $errYears == "") {
    $per_cardnoResult = array("success" => true,
                    "result" => $result,
                    "table_year" => $resultYears[0],
                    "msg" => "");
}else {
    $per_cardnoResult = array("success" => null,
                    "result" => null,
                    "table_year" => null,
                    "msg" => $errYears.$errPer_cardno);
}

echo json_encode($per_cardnoResult);